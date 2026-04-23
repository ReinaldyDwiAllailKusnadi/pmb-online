<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProgramStudi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = (int) $request->integer('year', now()->year);
        $availableYears = Pendaftaran::query()
            ->selectRaw('YEAR(created_at) as year')
            ->whereNotNull('created_at')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->map(fn ($year) => (int) $year)
            ->values();

        if ($availableYears->isEmpty()) {
            $availableYears = collect([$selectedYear]);
        }

        if (! $availableYears->contains($selectedYear)) {
            $selectedYear = (int) $availableYears->first();
        }

        $baseQuery = Pendaftaran::query()->whereYear('created_at', $selectedYear);
        $totalPendaftar = (clone $baseQuery)->count();
        $totalTerverifikasi = (clone $baseQuery)->whereIn('status', ['verified', 'accepted'])->count();
        $totalMenungguReview = (clone $baseQuery)->whereIn('status', ['submitted', 'under_review', 'documents_uploaded'])->count();
        $totalDitolak = (clone $baseQuery)->where('status', 'rejected')->count();

        $lastApplicantUpdate = Pendaftaran::query()->latest('updated_at')->value('updated_at');
        $conversionRate = $totalPendaftar > 0
            ? round(($totalTerverifikasi / $totalPendaftar) * 100, 1)
            : 0;

        $paymentSummary = $this->paymentSummary($selectedYear);

        $stats = [
            'total_pendaftar' => $totalPendaftar,
            'terverifikasi' => $totalTerverifikasi,
            'total_deposit' => $paymentSummary['total'],
            'menunggu_berkas' => $totalMenungguReview,
            'ditolak' => $totalDitolak,
            'pendaftar_trend' => $this->yearOverYearTrend('created_at', $selectedYear),
            'terverifikasi_trend' => $this->yearOverYearTrend('verified_at', $selectedYear),
            'deposit_trend' => $paymentSummary['trend'],
            'menunggu_trend' => $totalMenungguReview > 0 ? 'Perlu Review' : 'Aman',
            'pendaftar_footer' => $lastApplicantUpdate
                ? 'Update ' . Carbon::parse($lastApplicantUpdate)->diffForHumans()
                : 'Belum ada data',
            'terverifikasi_footer' => 'Konversi: ' . $conversionRate . '%',
            'deposit_footer' => $paymentSummary['footer'],
            'menunggu_footer' => $totalMenungguReview . ' pendaftaran perlu ditinjau',
        ];

        $monthlyCounts = Pendaftaran::query()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $barData = collect(range(1, 12))->map(function (int $month) use ($monthlyCounts, $selectedYear) {
            return [
                'name' => Carbon::create($selectedYear, $month, 1)->locale('id')->isoFormat('MMM'),
                'value' => (int) ($monthlyCounts[$month] ?? 0),
                'isCurrent' => $selectedYear === now()->year && $month === now()->month,
                'isFuture' => $selectedYear === now()->year && $month > now()->month,
            ];
        })->values();

        $programRows = Pendaftaran::query()
            ->leftJoin('program_studi', 'applicants.program_studi_id', '=', 'program_studi.id')
            ->whereYear('applicants.created_at', $selectedYear)
            ->where(function ($query) {
                $query->whereIn('program_studi.nama', ProgramStudi::officialNames())
                    ->orWhereNull('program_studi.nama');
            })
            ->selectRaw("
                COALESCE(program_studi.nama, 'Belum Memilih Prodi') as name,
                COUNT(applicants.id) as total
            ")
            ->groupBy('name')
            ->orderByDesc('total')
            ->get();

        $palette = ['#022448', '#F0A500', '#805600', '#1E3A5F', '#64748B', '#94A3B8'];
        $pieData = $programRows->map(function ($row, int $index) use ($totalPendaftar, $palette) {
            $count = (int) $row->total;

            return [
                'name' => trim((string) $row->name),
                'value' => $totalPendaftar > 0 ? round(($count / $totalPendaftar) * 100, 1) : 0,
                'count' => $count,
                'color' => $palette[$index % count($palette)],
            ];
        })->values();

        if ($pieData->isEmpty()) {
            $pieData = collect([
                ['name' => 'Belum ada data', 'value' => 1, 'count' => 0, 'color' => '#f1f5f9'],
            ]);
        }

        $programCount = $programRows->count();

        $schools = $this->topSchools($selectedYear);

        return view('admin.laporan', compact(
            'stats',
            'barData',
            'pieData',
            'schools',
            'selectedYear',
            'availableYears',
            'programCount'
        ));
    }

    public function exportPdf()
    {
        return back()->with('success', 'Export PDF belum tersedia.');
    }

    public function exportExcel()
    {
        return back()->with('success', 'Export Excel belum tersedia.');
    }

    public function sendEmail()
    {
        return back()->with('success', 'Pengiriman email laporan belum tersedia.');
    }

    private function yearOverYearTrend(string $dateColumn, int $selectedYear): string
    {
        $current = Pendaftaran::query()->whereYear($dateColumn, $selectedYear)->count();
        $previous = Pendaftaran::query()->whereYear($dateColumn, $selectedYear - 1)->count();

        if ($previous === 0) {
            return $current > 0 ? 'Baru' : '0%';
        }

        $change = round((($current - $previous) / $previous) * 100, 1);

        return ($change > 0 ? '+' : '') . $change . '%';
    }

    private function paymentSummary(int $selectedYear): array
    {
        if (! Schema::hasTable('pembayaran')) {
            return [
                'total' => 'Rp 0',
                'trend' => 'N/A',
                'footer' => 'Modul pembayaran belum aktif',
            ];
        }

        $query = DB::table('pembayaran')->whereYear('created_at', $selectedYear);

        if (Schema::hasColumn('pembayaran', 'status')) {
            $query->whereIn('status', ['paid', 'success', 'settlement', 'verified']);
        }

        $amountColumn = collect(['amount', 'nominal', 'total', 'jumlah'])
            ->first(fn ($column) => Schema::hasColumn('pembayaran', $column));

        $total = $amountColumn ? (clone $query)->sum($amountColumn) : 0;
        $transactions = (clone $query)->count();

        return [
            'total' => 'Rp ' . number_format((float) $total, 0, ',', '.'),
            'trend' => $transactions > 0 ? 'Aktif' : '0%',
            'footer' => number_format($transactions) . ' transaksi sukses',
        ];
    }

    private function topSchools(int $selectedYear)
    {
        if (! Schema::hasColumn('applicants', 'asal_sekolah')) {
            return collect();
        }

        $locationParts = collect(['province', 'city', 'district'])
            ->filter(fn ($column) => Schema::hasColumn('applicants', $column))
            ->map(fn ($column) => "NULLIF({$column}, '')")
            ->implode(', ');

        $locationExpression = $locationParts
            ? "COALESCE({$locationParts}, '-')"
            : "'-'";

        return Pendaftaran::query()
            ->whereYear('created_at', $selectedYear)
            ->whereNotNull('asal_sekolah')
            ->whereRaw("TRIM(asal_sekolah) <> ''")
            ->selectRaw("asal_sekolah, {$locationExpression} as location, COUNT(*) as total")
            ->groupBy('asal_sekolah', 'location')
            ->orderByDesc('total')
            ->limit(4)
            ->get()
            ->map(fn ($school, int $index) => [
                'id' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'name' => $school->asal_sekolah,
                'location' => $school->location ?: '-',
                'count' => (int) $school->total,
            ]);
    }
}
