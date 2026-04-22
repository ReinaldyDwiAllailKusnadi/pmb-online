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

        $pendaftaran = $query->latest()->paginate(15)->withQueryString();

        $totalPendaftar = Pendaftaran::count();
        $totalDiverifikasi = Pendaftaran::where('status', 'verified')->count();
        $totalMenunggu = Pendaftaran::whereIn('status', ['submitted', 'under_review'])->count();
        $programStudi = ProgramStudi::where('is_active', true)->orderBy('nama')->get();
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

        return $query->latest()->get();
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
