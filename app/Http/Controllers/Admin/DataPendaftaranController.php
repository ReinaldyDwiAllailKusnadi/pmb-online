<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Notification;
use App\Models\Pendaftaran;
use App\Models\ProgramStudi;
use App\Services\PendaftaranStatusService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class DataPendaftaranController extends Controller
{
    private const DOCUMENT_COLUMNS = [
        'photo' => 'photo_path',
        'id-card' => 'id_card_path',
        'family-card' => 'family_card_path',
        'diploma' => 'diploma_path',
        'transcript' => 'transcript_path',
    ];

    public function index(Request $request)
    {
        $query = Pendaftaran::query()->with(['user', 'programStudi', 'gelombangPendaftaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('prodi')) {
            $query->where('program_studi_id', $request->integer('prodi'));
        }

        if ($request->filled('gelombang')) {
            $query->where('gelombang_pendaftaran_id', $request->integer('gelombang'));
        }

        if ($request->filled('q')) {
            $search = trim($request->string('q')->toString());

            $query->where(function ($query) use ($search) {
                $query->where('nomor_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('programStudi', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")
                            ->orWhere('jenjang', 'like', "%{$search}%");
                    });
            });
        }

        $pendaftaran = $query->latest()->paginate(15)->withQueryString();

        $totalPendaftar = Pendaftaran::count();
        $totalDiverifikasi = Pendaftaran::whereIn('status', ['verified', 'accepted'])->count();
        $totalMenunggu = Pendaftaran::whereIn('status', ['submitted', 'under_review'])->count();
        $programStudi = ProgramStudi::officialActiveOptions();
        $gelombangPendaftaran = GelombangPendaftaran::where('is_active', true)
            ->orderBy('tanggal_mulai')
            ->orderBy('nama')
            ->get();

        return view('admin.data-pendaftaran', compact(
            'pendaftaran',
            'totalPendaftar',
            'totalDiverifikasi',
            'totalMenunggu',
            'programStudi',
            'gelombangPendaftaran'
        ));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->loadMissing(['user', 'programStudi', 'gelombangPendaftaran']);

        $histories = DB::table('status_histories')
            ->leftJoin('users', 'status_histories.user_id', '=', 'users.id')
            ->where('pendaftaran_id', $pendaftaran->id)
            ->orderBy('status_histories.created_at')
            ->select([
                'status_histories.*',
                'users.name as actor_name',
            ])
            ->get();

        $documents = $this->documentsFor($pendaftaran);

        return view('admin.data-pendaftaran-detail', compact('pendaftaran', 'histories', 'documents'));
    }

    public function create()
    {
        return view('admin.data-pendaftaran-form', array_merge(
            $this->formOptions(),
            [
                'mode' => 'create',
                'pendaftaran' => new Pendaftaran([
                    'status' => 'draft',
                ]),
            ]
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validatedCrudData($request);
        $status = $validated['status'];
        $now = now();

        $pendaftaran = Pendaftaran::create(array_merge($validated, [
            'nomor_pendaftaran' => $validated['nomor_pendaftaran'] ?: $this->generateNomorPendaftaran(),
            'submitted_at' => in_array($status, ['submitted', 'under_review', 'revision_required', 'verified', 'accepted', 'rejected'], true) ? $now : null,
            'verified_at' => in_array($status, ['verified', 'accepted'], true) ? $now : null,
            'verified_by' => in_array($status, ['verified', 'accepted'], true) ? $request->user()->id : null,
        ]));

        DB::table('status_histories')->insert([
            'pendaftaran_id' => $pendaftaran->id,
            'user_id' => $request->user()->id,
            'status_from' => null,
            'status_to' => $pendaftaran->status,
            'catatan' => 'Data pendaftaran dibuat oleh admin.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.data-pendaftaran.show', $pendaftaran)
            ->with('success', 'Data pendaftaran berhasil ditambahkan.');
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        $pendaftaran->loadMissing(['programStudi', 'gelombangPendaftaran']);

        return view('admin.data-pendaftaran-form', array_merge(
            $this->formOptions(),
            [
                'mode' => 'edit',
                'pendaftaran' => $pendaftaran,
            ]
        ));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $this->validatedCrudData($request, $pendaftaran);
        $statusTo = $validated['status'];
        $statusFrom = $pendaftaran->status;
        $note = $validated['catatan_admin'] ?: 'Data pendaftaran diperbarui oleh admin.';

        $updates = $validated;
        unset($updates['status']);

        if (in_array($statusTo, ['submitted', 'under_review', 'revision_required', 'verified', 'accepted', 'rejected'], true) && ! $pendaftaran->submitted_at) {
            $updates['submitted_at'] = now();
        }

        if (in_array($statusTo, ['verified', 'accepted'], true) && ! $pendaftaran->verified_at) {
            $updates['verified_at'] = now();
            $updates['verified_by'] = $request->user()->id;
        }

        if ($statusFrom !== $statusTo) {
            app(PendaftaranStatusService::class)->transition(
                pendaftaran: $pendaftaran,
                statusTo: $statusTo,
                actor: $request->user(),
                note: $note,
                updates: $updates
            );
        } else {
            $pendaftaran->update($updates);
        }

        return redirect()
            ->route('admin.data-pendaftaran.show', $pendaftaran)
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();

        return redirect()
            ->route('admin.data-pendaftaran')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function showDocument(Pendaftaran $pendaftaran, string $document): Response
    {
        abort_unless(array_key_exists($document, self::DOCUMENT_COLUMNS), 404);

        $path = $pendaftaran->{self::DOCUMENT_COLUMNS[$document]};
        abort_unless($this->isApplicantDocument($path, $pendaftaran), 404);

        $disk = $this->documentDisk($path);
        abort_unless($disk, 404);

        return Storage::disk($disk)->response($path, basename($path), [
            'Content-Type' => Storage::disk($disk)->mimeType($path) ?: 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function markUnderReview(Request $request, Pendaftaran $pendaftaran)
    {
        app(PendaftaranStatusService::class)->transition(
            pendaftaran: $pendaftaran,
            statusTo: 'under_review',
            actor: $request->user(),
            note: $request->input('catatan_admin') ?: 'Pendaftaran mulai ditinjau oleh admin.',
            updates: [
                'catatan_admin' => $request->input('catatan_admin'),
            ]
        );

        return back()->with('success', 'Pendaftaran masuk tahap review.');
    }

    public function verify(Request $request, Pendaftaran $pendaftaran)
    {
        $note = $request->input('catatan_admin') ?: 'Pendaftaran telah diverifikasi oleh admin.';
        $shouldNotify = $pendaftaran->status !== 'verified';

        app(PendaftaranStatusService::class)->transition(
            pendaftaran: $pendaftaran,
            statusTo: 'verified',
            actor: $request->user(),
            note: $note,
            updates: [
                'catatan_admin' => $note,
                'verified_at' => now(),
                'verified_by' => $request->user()->id,
            ]
        );

        if ($shouldNotify) {
            $this->notifyApplicant(
                $pendaftaran,
                'Pendaftaran Diterima',
                'Selamat! Pendaftaran Anda telah disetujui.',
                'success'
            );
        }

        return back()->with('success', 'Pendaftaran berhasil diverifikasi.');
    }

    public function reject(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ]);
        $shouldNotify = $pendaftaran->status !== 'rejected';

        app(PendaftaranStatusService::class)->transition(
            pendaftaran: $pendaftaran,
            statusTo: 'rejected',
            actor: $request->user(),
            note: $validated['catatan_admin'],
            updates: [
                'catatan_admin' => $validated['catatan_admin'],
            ]
        );

        if ($shouldNotify) {
            $this->notifyApplicant(
                $pendaftaran,
                'Pendaftaran Ditolak',
                'Maaf, pendaftaran Anda ditolak.',
                'error'
            );
        }

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }

    public function requestRevision(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ]);
        $shouldNotify = $pendaftaran->status !== 'revision_required';

        app(PendaftaranStatusService::class)->transition(
            pendaftaran: $pendaftaran,
            statusTo: 'revision_required',
            actor: $request->user(),
            note: $validated['catatan_admin'],
            updates: [
                'catatan_admin' => $validated['catatan_admin'],
            ]
        );

        if ($shouldNotify) {
            $this->notifyApplicant(
                $pendaftaran,
                'Perlu Revisi',
                'Silakan perbaiki data Anda sesuai catatan admin.',
                'warning'
            );
        }

        return back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->filteredData($request);

        return Excel::download(new PendaftaranExport($data), 'data-pendaftaran.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $pendaftaran = $this->filteredData($request);
        $pdf = Pdf::loadView('admin.exports.pendaftaran-pdf', compact('pendaftaran'));

        return $pdf->download('data-pendaftaran.pdf');
    }

    private function filteredData(Request $request)
    {
        $query = Pendaftaran::query()->with(['user', 'programStudi', 'gelombangPendaftaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('prodi')) {
            $query->where('program_studi_id', $request->integer('prodi'));
        }

        if ($request->filled('gelombang')) {
            $query->where('gelombang_pendaftaran_id', $request->integer('gelombang'));
        }

        if ($request->filled('q')) {
            $search = trim($request->string('q')->toString());

            $query->where(function ($query) use ($search) {
                $query->where('nomor_pendaftaran', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('programStudi', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")
                            ->orWhere('jenjang', 'like', "%{$search}%");
                    });
            });
        }

        return $query->latest()->get();
    }

    private function formOptions(): array
    {
        return [
            'programStudi' => ProgramStudi::officialActiveOptions(),
            'gelombangPendaftaran' => GelombangPendaftaran::where('is_active', true)
                ->orderBy('tanggal_mulai')
                ->orderBy('nama')
                ->get(),
            'statusOptions' => collect(\App\Support\StudentStatusPresenter::labels())
                ->except('terkirim')
                ->all(),
        ];
    }

    private function validatedCrudData(Request $request, ?Pendaftaran $pendaftaran = null): array
    {
        $id = $pendaftaran?->id;

        return $request->validate([
            'nomor_pendaftaran' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('applicants', 'nomor_pendaftaran')->ignore($id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('applicants', 'email')->ignore($id),
            ],
            'program_studi_id' => [
                'nullable',
                Rule::exists('program_studi', 'id')
                    ->where(fn ($query) => $query
                        ->where('is_active', true)
                        ->whereIn('nama', ProgramStudi::officialNames())),
            ],
            'gelombang_pendaftaran_id' => ['nullable', 'exists:gelombang_pendaftaran,id'],
            'status' => ['required', Rule::in($this->statusOptions())],
            'catatan_admin' => [
                Rule::requiredIf(fn () => in_array($request->input('status'), ['rejected', 'revision_required'], true)),
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    private function statusOptions(): array
    {
        return [
            'draft',
            'in_progress',
            'documents_uploaded',
            'submitted',
            'under_review',
            'revision_required',
            'verified',
            'accepted',
            'rejected',
        ];
    }

    private function generateNomorPendaftaran(): string
    {
        do {
            $number = 'PMB-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Pendaftaran::where('nomor_pendaftaran', $number)->exists());

        return $number;
    }

    private function documentsFor(Pendaftaran $pendaftaran): array
    {
        return [
            [
                'key' => 'photo',
                'label' => 'Pas Foto Formal',
                'path' => $pendaftaran->photo_path,
            ],
            [
                'key' => 'id-card',
                'label' => 'KTP / Identitas',
                'path' => $pendaftaran->id_card_path,
            ],
            [
                'key' => 'family-card',
                'label' => 'Kartu Keluarga',
                'path' => $pendaftaran->family_card_path,
            ],
            [
                'key' => 'diploma',
                'label' => 'Ijazah Terakhir',
                'path' => $pendaftaran->diploma_path,
            ],
            [
                'key' => 'transcript',
                'label' => 'Transkrip Nilai',
                'path' => $pendaftaran->transcript_path,
            ],
        ];
    }

    private function isApplicantDocument(?string $path, Pendaftaran $pendaftaran): bool
    {
        if (blank($path)) {
            return false;
        }

        return str_starts_with($path, 'applicants/' . $pendaftaran->id . '/');
    }

    private function documentDisk(?string $path): ?string
    {
        foreach (['local', 'public'] as $disk) {
            if ($path && Storage::disk($disk)->exists($path)) {
                return $disk;
            }
        }

        return null;
    }

    private function notifyApplicant(Pendaftaran $pendaftaran, string $title, string $message, string $type): void
    {
        if (! $pendaftaran->user_id) {
            return;
        }

        Notification::create([
            'user_id' => $pendaftaran->user_id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'is_read' => false,
            'created_at' => now(),
        ]);
    }

}
