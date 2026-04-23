<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class UnduhBuktiController extends Controller
{
    private const PDF_ALLOWED_STATUSES = ['verified', 'accepted'];

    public function index(Request $request)
    {
        $student = $this->buildStudent($request);
        $institution = $this->institutionProfile();

        return view('mahasiswa.unduh-bukti', compact('student', 'institution'));
    }

    public function downloadPdf(Request $request)
    {
        $student = $this->buildStudent($request);
        $institution = $this->institutionProfile();

        if (! $student->pdf_available) {
            return back()->withErrors(['pdf' => 'Bukti PDF baru dapat diunduh setelah pendaftaran Anda disetujui admin.']);
        }

        if (! $student->nomor_resmi) {
            return back()->withErrors(['pdf' => 'Bukti pendaftaran belum dapat diunduh karena nomor pendaftaran belum tersedia.']);
        }

        $pdf = Pdf::loadView('mahasiswa.pdf-bukti', compact('student', 'institution'));

        return $pdf->download('bukti-pendaftaran-' . $student->no_pendaftaran . '.pdf');
    }

    private function buildStudent(Request $request): stdClass
    {
        $user = $request->user();
        $applicant = $this->getApplicant($request)->loadMissing(['programStudi', 'gelombangPendaftaran']);
        $programStudi = $this->resolveProgramStudi($applicant);
        $gelombang = $this->resolveGelombang($applicant);

        $student = new stdClass();
        $student->nama_lengkap = $applicant->full_name ?: $user->name;
        $student->program_studi = $programStudi['nama'];
        $student->fakultas = $programStudi['fakultas'];
        $student->gelombang = $gelombang['nama'];
        $student->tahun_akademik = $gelombang['tahun_akademik'];
        $student->asal_sekolah = $applicant->asal_sekolah;
        $student->lokasi_ujian = $applicant->lokasi_ujian;
        $student->status = $applicant->status;
        $student->pdf_available = in_array($applicant->status, self::PDF_ALLOWED_STATUSES, true);
        $student->pdf_unavailable_message = 'Bukti PDF baru dapat diunduh setelah pendaftaran Anda disetujui admin.';
        $student->nomor_resmi = (bool) $applicant->nomor_pendaftaran;
        $student->no_pendaftaran = $applicant->nomor_pendaftaran ?: 'Belum tersedia';
        $student->tanggal_cetak = now()->translatedFormat('d F Y');
        $student->foto = $applicant->photo_path ?: null;
        $student->foto_url = $student->foto && $this->documentDisk($student->foto)
            ? route('mahasiswa.dokumen.show', 'photo')
            : null;
        $fotoDisk = $this->documentDisk($student->foto);
        $student->foto_pdf_path = $student->foto && $fotoDisk
            ? Storage::disk($fotoDisk)->path($student->foto)
            : null;

        return $student;
    }

    private function resolveProgramStudi(Pendaftaran $applicant): array
    {
        $program = $applicant->relationLoaded('programStudi')
            ? $applicant->getRelation('programStudi')
            : $applicant->programStudi()->first();

        return [
            'nama' => $program?->displayName(),
            'fakultas' => $program?->fakultas,
        ];
    }

    private function resolveGelombang(Pendaftaran $applicant): array
    {
        $gelombang = $applicant->relationLoaded('gelombangPendaftaran')
            ? $applicant->getRelation('gelombangPendaftaran')
            : $applicant->gelombangPendaftaran()->first();

        return [
            'nama' => $gelombang?->nama,
            'tahun_akademik' => $gelombang?->tahun_akademik,
        ];
    }

    private function institutionProfile(): array
    {
        if (! Storage::disk('local')->exists('institution-profile.json')) {
            return [
                'nama' => config('app.name'),
                'kode_dikti' => null,
                'alamat' => null,
                'email' => null,
                'telepon' => null,
                'website' => null,
                'logo' => null,
            ];
        }

        $profile = json_decode(Storage::disk('local')->get('institution-profile.json'), true);

        return array_merge([
            'nama' => config('app.name'),
            'kode_dikti' => null,
            'alamat' => null,
            'email' => null,
            'telepon' => null,
            'website' => null,
            'logo' => null,
        ], is_array($profile) ? $profile : []);
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

    private function documentDisk(?string $path): ?string
    {
        foreach (['local', 'public'] as $disk) {
            if ($path && Storage::disk($disk)->exists($path)) {
                return $disk;
            }
        }

        return null;
    }
}
