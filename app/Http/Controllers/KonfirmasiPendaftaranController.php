<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

class KonfirmasiPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $email = $user?->email ?? 'budi.santoso@example.com';

        $applicant = Applicant::firstOrCreate(
            ['email' => $email],
            ['full_name' => $user?->name ?? 'Aditya Pratama', 'status' => 'draft']
        );

        $pendaftaran = $this->buildPendaftaran($applicant, $user);
        $dokumen = $this->buildDokumen($applicant);
        $currentStep = 3;

        return view('mahasiswa.konfirmasi-pendaftaran', compact('pendaftaran', 'dokumen', 'currentStep'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'pernyataan' => ['accepted'],
        ]);

        $user = Auth::user();
        $email = $user?->email ?? 'budi.santoso@example.com';

        $applicant = Applicant::firstOrCreate(
            ['email' => $email],
            ['full_name' => $user?->name ?? 'Aditya Pratama', 'status' => 'draft']
        );

        $applicant->update(['status' => 'terkirim']);

        return redirect()
            ->route('mahasiswa.konfirmasi')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    private function buildPendaftaran(Applicant $applicant, $user): stdClass
    {
        $pendaftaran = new stdClass();
        $pendaftaran->nama_lengkap = $applicant->full_name ?? ($user?->name ?? 'Aditya Pratama');
        $pendaftaran->nik = $applicant->nik ?? '3201234567890001';
        $pendaftaran->tempat_lahir = $applicant->birth_place ?? 'Jakarta';
        $pendaftaran->tanggal_lahir = $this->buildTanggalLahir($applicant);
        $pendaftaran->email = $applicant->email ?? ($user?->email ?? 'aditya.pratama@email.com');
        $pendaftaran->alamat_ktp = $applicant->address ?? 'Jl. Kebangsaan No. 45, RT 02/RW 05, Kel. Senayan, Kec. Kebayoran Baru, Jakarta Selatan, 12190';
        $pendaftaran->prodi_pilihan_1 = $applicant->prodi_pilihan_1 ?? 'S1 Teknik Informatika';
        $pendaftaran->prodi_pilihan_2 = $applicant->prodi_pilihan_2 ?? 'S1 Sistem Informasi';

        return $pendaftaran;
    }

    private function buildTanggalLahir(Applicant $applicant): string
    {
        if ($applicant->birth_day && $applicant->birth_month && $applicant->birth_year) {
            return Carbon::createFromDate(
                (int) $applicant->birth_year,
                (int) $applicant->birth_month,
                (int) $applicant->birth_day
            )->toDateString();
        }

        return '2004-08-12';
    }

    private function buildDokumen(Applicant $applicant): array
    {
        return collect([
            ['name' => 'Pas Foto 3x4', 'path' => $applicant->photo_path, 'fallback' => 'foto_profil.jpg', 'size' => '1.2MB'],
            ['name' => 'Scan KTP', 'path' => $applicant->id_card_path, 'fallback' => 'ktp_aditya.pdf', 'size' => '450KB'],
            ['name' => 'Ijazah / SKL', 'path' => $applicant->diploma_path, 'fallback' => 'ijazah_sma.pdf', 'size' => '2.1MB'],
            ['name' => 'Sertifikat Prestasi', 'path' => $applicant->transcript_path, 'fallback' => 'sertif_olimpiade.pdf', 'size' => '3.4MB'],
        ])->map(function (array $doc) {
            $filename = $doc['path'] ? basename($doc['path']) : $doc['fallback'];
            $size = $doc['path'] ? $this->formatFileSize($doc['path']) : $doc['size'];

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

        if (! Storage::disk('public')->exists($path)) {
            return '0KB';
        }

        $bytes = Storage::disk('public')->size($path);

        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), 1) . 'MB';
        }

        return number_format($bytes / 1024, 0) . 'KB';
    }
}
