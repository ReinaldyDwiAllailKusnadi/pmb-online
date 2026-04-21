<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class DataPendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::query()->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('prodi') && Schema::hasColumn('applicants', 'program_studi')) {
            $query->where('program_studi', $request->string('prodi'));
        }

        if ($request->filled('gelombang') && Schema::hasColumn('applicants', 'gelombang')) {
            $query->where('gelombang', $request->string('gelombang'));
        }

        $pendaftaran = $query->latest()->paginate(15)->withQueryString();

        $totalPendaftar = Pendaftaran::count();
        $totalDiverifikasi = Pendaftaran::where('status', 'Diverifikasi')->count();
        $totalMenunggu = Pendaftaran::where('status', 'Menunggu')->count();

        return view('admin.data-pendaftaran', compact('pendaftaran', 'totalPendaftar', 'totalDiverifikasi', 'totalMenunggu'));
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
        $query = Pendaftaran::query()->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('prodi') && Schema::hasColumn('applicants', 'program_studi')) {
            $query->where('program_studi', $request->string('prodi'));
        }

        if ($request->filled('gelombang') && Schema::hasColumn('applicants', 'gelombang')) {
            $query->where('gelombang', $request->string('gelombang'));
        }

        return $query->latest()->get();
    }
}
