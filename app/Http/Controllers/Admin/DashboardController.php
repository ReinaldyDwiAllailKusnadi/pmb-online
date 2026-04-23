<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Support\StudentStatusPresenter;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPendaftar = Pendaftaran::count();
        $pendaftarHariIni = Pendaftaran::whereDate('created_at', today())->count();
        $sudahDiverifikasi = Pendaftaran::whereIn('status', ['verified', 'accepted'])->count();
        $ditolak = Pendaftaran::whereIn('status', ['rejected', 'revision_required'])->count();
        $menungguReview = Pendaftaran::whereIn('status', ['submitted', 'under_review'])->count();
        $persenDiverifikasi = $totalPendaftar > 0
            ? round(($sudahDiverifikasi / $totalPendaftar) * 100) . '%'
            : '0%';

        $thisMonth = Pendaftaran::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $previousMonth = Pendaftaran::whereBetween('created_at', [
            now()->subMonthNoOverflow()->startOfMonth(),
            now()->subMonthNoOverflow()->endOfMonth(),
        ])->count();

        $stats = [
            'total_pendaftar' => $totalPendaftar,
            'pendaftar_hari_ini' => $pendaftarHariIni,
            'sudah_diverifikasi' => $sudahDiverifikasi,
            'ditolak' => $ditolak,
            'menunggu_review' => $menungguReview,
            'persen_diverifikasi' => $persenDiverifikasi,
            'last_update' => now()->format('H:i'),
            'trend_persen' => $this->monthlyTrendLabel($thisMonth, $previousMonth),
        ];

        $pendaftaranTerbaru = Pendaftaran::with(['user', 'programStudi', 'gelombangPendaftaran'])
            ->latest()
            ->take(5)
            ->get();
        $registrationChart = $this->buildRegistrationChart();
        $chartLabels = $registrationChart['labels'];
        $chartValues = $registrationChart['values'];
        $chartDates = $registrationChart['dates'];
        $statusLabels = $this->statusLabels();
        $statusBadgeClasses = $this->statusBadgeClasses();

        return view('admin.dashboard', compact(
            'stats',
            'pendaftaranTerbaru',
            'chartLabels',
            'chartValues',
            'chartDates',
            'statusLabels',
            'statusBadgeClasses'
        ));
    }

    private function buildRegistrationChart(): array
    {
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today();

        $countsByDate = Pendaftaran::query()
            ->selectRaw('DATE(created_at) as registration_date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'registration_date');

        $days = collect(CarbonPeriod::create($startDate, $endDate))->map(function (Carbon $date) use ($countsByDate) {
            $dateKey = $date->toDateString();

            return [
                'date' => $dateKey,
                'label' => $date->translatedFormat('D'),
                'count' => (int) ($countsByDate[$dateKey] ?? 0),
            ];
        });

        return [
            'labels' => $days->pluck('label')->all(),
            'values' => $days->pluck('count')->all(),
            'dates' => $days->pluck('date')->all(),
        ];
    }

    private function monthlyTrendLabel(int $thisMonth, int $previousMonth): string
    {
        if ($previousMonth === 0) {
            return $thisMonth > 0 ? '+100%' : '0%';
        }

        $percentage = round((($thisMonth - $previousMonth) / $previousMonth) * 100);

        return ($percentage > 0 ? '+' : '') . $percentage . '%';
    }

    private function statusLabels(): array
    {
        return StudentStatusPresenter::labels();
    }

    private function statusBadgeClasses(): array
    {
        return [
            'draft' => 'bg-slate-50 text-slate-600 border-slate-200',
            'in_progress' => 'bg-blue-50 text-blue-600 border-blue-100',
            'documents_uploaded' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
            'submitted' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
            'under_review' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
            'revision_required' => 'bg-orange-50 text-orange-700 border-orange-100',
            'verified' => 'bg-green-50 text-green-600 border-green-100',
            'accepted' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'rejected' => 'bg-red-50 text-red-600 border-red-100',
        ];
    }
}
