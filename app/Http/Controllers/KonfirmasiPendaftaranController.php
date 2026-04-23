<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Services\PendaftaranStatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use stdClass;

class KonfirmasiPendaftaranController extends Controller
{
    private const DOCUMENT_COLUMNS = [
        'photo_path' => 'Pas foto',
        'id_card_path' => 'KTP / identitas',
        'family_card_path' => 'Kartu keluarga',
        'diploma_path' => 'Ijazah terakhir',
        'transcript_path' => 'Transkrip nilai',
    ];

    public function index(Request $request)
    {
        $applicant = $this->getApplicant($request);

        if (in_array($applicant->status, ['submitted', 'under_review', 'verified', 'accepted', 'rejected'], true)) {
            return redirect()->route('status.pendaftaran');
        }

        return redirect()->route('form.step3');
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'pernyataan' => ['accepted'],
        ]);

        $applicant = $this->getApplicant($request);

        if (in_array($applicant->status, ['submitted', 'under_review', 'verified', 'accepted', 'rejected'], true)) {
            return redirect()
                ->route('status.pendaftaran')
                ->with('success', 'Pendaftaran sudah pernah dikirim.');
        }

        $this->assertReadyToSubmit($applicant);

        app(PendaftaranStatusService::class)->transition(
            pendaftaran: $applicant,
            statusTo: 'submitted',
            actor: $request->user(),
            note: 'Pendaftaran dikirim oleh calon mahasiswa.',
            updates: [
                'submitted_at' => $applicant->submitted_at ?: now(),
                'nomor_pendaftaran' => $applicant->nomor_pendaftaran ?: $this->generateNomorPendaftaran($applicant),
            ]
        );

        $this->notifyAdminsOfNewSubmission($applicant);

        return redirect()
            ->route('status.pendaftaran')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    private function buildPendaftaran(Pendaftaran $applicant, $user): stdClass
    {
        $gelombangPendaftaran = $applicant->relationLoaded('gelombangPendaftaran')
            ? $applicant->getRelation('gelombangPendaftaran')
            : $applicant->gelombangPendaftaran()->first();

        $pendaftaran = new stdClass();
        $pendaftaran->nama_lengkap = $applicant->full_name ?: $user->name;
        $pendaftaran->nik = $applicant->nik;
        $pendaftaran->tempat_lahir = $applicant->birth_place;
        $pendaftaran->tanggal_lahir = $this->buildTanggalLahir($applicant);
        $pendaftaran->email = $applicant->email ?: $user->email;
        $pendaftaran->alamat_ktp = $applicant->address;
        $pendaftaran->prodi_pilihan_1 = $applicant->program_studi;
        $pendaftaran->prodi_pilihan_2 = $gelombangPendaftaran?->nama;

        return $pendaftaran;
    }

    private function buildTanggalLahir(Pendaftaran $applicant): ?string
    {
        $month = $this->normalizeBirthMonth($applicant->birth_month);

        if ($applicant->birth_day && $month && $applicant->birth_year) {
            return Carbon::createFromDate(
                (int) $applicant->birth_year,
                $month,
                (int) $applicant->birth_day
            )->toDateString();
        }

        return null;
    }

    private function normalizeBirthMonth(?string $month): ?int
    {
        if (! $month) {
            return null;
        }

        if (is_numeric($month)) {
            return (int) $month;
        }

        return [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ][$month] ?? null;
    }

    private function buildDokumen(Pendaftaran $applicant): array
    {
        return collect([
            ['name' => 'Pas Foto 3x4', 'path' => $applicant->photo_path],
            ['name' => 'Scan KTP', 'path' => $applicant->id_card_path],
            ['name' => 'Ijazah / SKL', 'path' => $applicant->diploma_path],
            ['name' => 'Sertifikat Prestasi', 'path' => $applicant->transcript_path],
        ])->map(function (array $doc) {
            $filename = $doc['path'] ? basename($doc['path']) : 'Belum diunggah';
            $size = $doc['path'] ? $this->formatFileSize($doc['path']) : '0KB';

            return [
                'name' => $doc['name'],
                'filename' => $filename,
                'size' => $size,
            ];
        })->all();
    }

    private function formatFileSize(?string $path): string
    {
        if (! $path) {
            return '0KB';
        }

        $disk = $this->documentDisk($path);

        if (! $disk) {
            return '0KB';
        }

        $bytes = Storage::disk($disk)->size($path);

        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), 1) . 'MB';
        }

        return number_format($bytes / 1024, 0) . 'KB';
    }

    private function generateNomorPendaftaran(Pendaftaran $applicant): string
    {
        return 'PMB-' . now()->format('Y') . '-' . str_pad((string) $applicant->id, 5, '0', STR_PAD_LEFT);
    }

    private function assertReadyToSubmit(Pendaftaran $applicant): void
    {
        if (! in_array($applicant->status, ['in_progress', 'documents_uploaded', 'revision_required'], true)) {
            throw ValidationException::withMessages([
                'status' => 'Pendaftaran belum dapat dikirim pada status saat ini.',
            ]);
        }

        $missing = [];

        foreach ([
            'full_name' => 'Nama lengkap',
            'email' => 'Email',
            'program_studi_id' => 'Program studi',
            'gelombang_pendaftaran_id' => 'Gelombang pendaftaran',
        ] as $field => $label) {
            if (blank($applicant->{$field})) {
                $missing[] = $label;
            }
        }

        foreach (self::DOCUMENT_COLUMNS as $field => $label) {
            if (! $this->documentExists($applicant->{$field})) {
                $missing[] = $label;
            }
        }

        if ($missing === []) {
            return;
        }

        throw ValidationException::withMessages([
            'documents' => 'Lengkapi data berikut sebelum mengirim pendaftaran: ' . implode(', ', $missing) . '.',
        ]);
    }

    private function getApplicant(Request $request): Pendaftaran
    {
        $user = $request->user();

        return Pendaftaran::query()->createOrFirst(['user_id' => $user->id], [
            'full_name' => $user->name,
            'email' => $user->email,
            'status' => 'draft',
        ]);
    }

    private function documentExists(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        return $this->documentDisk($path) !== null;
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

    private function notifyAdminsOfNewSubmission(Pendaftaran $applicant): void
    {
        $name = $applicant->full_name ?: $applicant->user?->name ?: 'Calon Mahasiswa';

        User::query()
            ->where('is_active', true)
            ->whereIn('role', ['SYSTEM ADMIN', 'system admin', 'ADMIN', 'admin', 'SYSTEM ADMINISTRATOR', 'SUPER ADMIN', 'SUPERADMIN'])
            ->get()
            ->each(function (User $admin) use ($name) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pendaftaran Baru',
                    'message' => 'Ada pendaftaran baru dari ' . $name,
                    'type' => 'info',
                    'is_read' => false,
                    'created_at' => now(),
                ]);
            });
    }
}
