<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPendaftar = Pendaftaran::count();
        $pendaftarHariIni = Pendaftaran::whereDate('created_at', today())->count();
        $sudahDiverifikasi = Pendaftaran::where('status', 'Diverifikasi')->count();
        $ditolak = Pendaftaran::where('status', 'Ditolak')->count();
        $persenDiverifikasi = $totalPendaftar > 0
            ? round(($sudahDiverifikasi / $totalPendaftar) * 100) . '%'
            : '0%';

        $stats = [
            'total_pendaftar' => $totalPendaftar,
            'pendaftar_hari_ini' => $pendaftarHariIni,
            'sudah_diverifikasi' => $sudahDiverifikasi,
            'ditolak' => $ditolak,
            'persen_diverifikasi' => $persenDiverifikasi,
            'last_update' => '10 menit lalu',
            'trend_persen' => '+12%',
        ];

        $pendaftaranTerbaru = Pendaftaran::with('user')->latest()->take(5)->get();
        $chartData = $this->buildChartData();

        return view('admin.dashboard', compact('stats', 'pendaftaranTerbaru', 'chartData'));
    }

    private function buildChartData(): array
    {
        $days = collect(range(6, 0))->map(function ($offset) {
            $date = Carbon::today()->subDays($offset);

            return [
                'date' => $date,
                'count' => Pendaftaran::whereDate('created_at', $date)->count(),
            ];
        });

        $max = max($days->pluck('count')->max(), 1);

        return $days->map(function ($day) use ($max) {
            return (int) round(($day['count'] / $max) * 100);
        })->all();
    }
}
