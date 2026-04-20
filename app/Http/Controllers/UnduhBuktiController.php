<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class UnduhBuktiController extends Controller
{
    public function index(Request $request)
    {
        $student = $this->buildStudent($request);

        return view('mahasiswa.unduh-bukti', compact('student'));
    }

    public function downloadPdf(Request $request)
    {
        $student = $this->buildStudent($request);

        $pdf = Pdf::loadView('mahasiswa.pdf-bukti', compact('student'));

        return $pdf->download('bukti-pendaftaran-' . $student->no_pendaftaran . '.pdf');
    }

    private function buildStudent(Request $request): stdClass
    {
        $user = Auth::user();
        $email = $user?->email ?? 'budi.santoso@example.com';

        $applicant = Applicant::firstOrCreate(
            ['email' => $email],
            ['full_name' => $user?->name ?? 'Ahmad Syarifuddin', 'status' => 'draft']
        );

        $student = new stdClass();
        $student->nama_lengkap = $applicant->full_name ?? ($user?->name ?? 'Ahmad Syarifuddin');
        $student->program_studi = 'Teknik Informatika (S1)';
        $student->asal_sekolah = 'SMAN 1 Jakarta';
        $student->lokasi_ujian = 'Gedung Rektorat Lt. 2';
        $student->no_pendaftaran = 'PMB-2024-00128';
        $student->foto = $applicant->photo_path ?: null;
        $student->foto_url = $student->foto
            ? asset('storage/' . $student->foto)
            : 'https://ui-avatars.com/api/?name=' . urlencode($student->nama_lengkap);

        return $student;
    }
}
