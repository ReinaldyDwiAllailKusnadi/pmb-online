@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'laporan'])
    @include('admin.partials.topbar', [
        'placeholder' => 'Cari laporan atau data...',
        'academicYear' => 'Tahun Laporan ' . $selectedYear,
    ])

    <main style="margin-left:260px; padding-top:64px; background:#F1F5F9;" class="p-8 pb-12">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold font-headline" style="color:#1E3A5F;">Laporan & Statistik</h1>
                <p class="mt-2 text-sm leading-relaxed max-w-2xl" style="color:#64748B;">
                    Analisis mendalam mengenai tren pendaftaran, distribusi program studi, dan performa asal sekolah mahasiswa baru.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="button" disabled aria-disabled="true" class="flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 opacity-60 shadow-sm" style="color:#1E3A5F;">
                    <i class="bi bi-funnel-fill"></i>
                    <span class="font-bold text-sm">Filter Segera Tersedia</span>
                </button>
                <a href="{{ route('admin.laporan', ['year' => $selectedYear]) }}" class="flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 font-bold text-white shadow-lg lift-hover active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="background-color:#1E3A5F;">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Perbarui Data</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-[28px] border border-slate-100 p-6 card-shadow lift-hover">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center justify-center rounded-xl" style="background:rgba(30,58,95,0.08); width:42px; height:42px;">
                        <i class="bi bi-person-plus-fill" style="color:#1E3A5F;"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full" style="color:#16a34a; background:rgba(22,163,74,0.1);">
                        {{ $stats['pendaftar_trend'] }}
                    </span>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-widest" style="color:#94a3b8;">Total Pendaftar</p>
                <h3 class="text-3xl font-black mt-1" style="color:#1E3A5F;">{{ number_format($stats['total_pendaftar']) }}</h3>
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest" style="color:#94a3b8;">
                    <i class="bi bi-clock-fill"></i>
                    <span>{{ $stats['pendaftar_footer'] }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-100 p-6 card-shadow lift-hover">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center justify-center rounded-xl" style="background:rgba(240,165,0,0.12); width:42px; height:42px;">
                        <i class="bi bi-check-circle-fill" style="color:#F0A500;"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full" style="color:#16a34a; background:rgba(22,163,74,0.1);">
                        {{ $stats['terverifikasi_trend'] }}
                    </span>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-widest" style="color:#94a3b8;">Terverifikasi</p>
                <h3 class="text-3xl font-black mt-1" style="color:#1E3A5F;">{{ number_format($stats['terverifikasi']) }}</h3>
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest" style="color:#94a3b8;">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>{{ $stats['terverifikasi_footer'] }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-100 p-6 card-shadow lift-hover">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center justify-center rounded-xl" style="background:rgba(2,36,72,0.08); width:42px; height:42px;">
                        <i class="bi bi-credit-card-2-front-fill" style="color:#022448;"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full" style="color:#64748B; background:#F8FAFC;">
                        {{ $stats['deposit_trend'] }}
                    </span>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-widest" style="color:#94a3b8;">Total Deposit</p>
                <h3 class="text-3xl font-black mt-1" style="color:#1E3A5F;">{{ $stats['total_deposit'] }}</h3>
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest" style="color:#94a3b8;">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>{{ $stats['deposit_footer'] }}</span>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-100 p-6 card-shadow lift-hover">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center justify-center rounded-xl" style="background:rgba(239,68,68,0.1); width:42px; height:42px;">
                        <i class="bi bi-hourglass-split" style="color:#ef4444;"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full" style="color:#ef4444; background:rgba(239,68,68,0.1);">
                        {{ $stats['menunggu_trend'] }}
                    </span>
                </div>
                <p class="text-[11px] font-bold uppercase tracking-widest" style="color:#94a3b8;">Menunggu Review</p>
                <h3 class="text-3xl font-black mt-1" style="color:#1E3A5F;">{{ number_format($stats['menunggu_berkas']) }}</h3>
                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest" style="color:#94a3b8;">
                    <i class="bi bi-clock-fill"></i>
                    <span>{{ $stats['menunggu_footer'] }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2 bg-white rounded-[28px] border border-slate-100 p-8 card-shadow">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-bold" style="color:#1E3A5F;">Tren Pendaftaran Bulanan</h3>
                        <p class="text-xs font-medium" style="color:#64748B;">Perbandingan jumlah pendaftar per bulan berjalan</p>
                    </div>
                    <form method="GET" action="{{ route('admin.laporan') }}">
                        <select name="year" onchange="this.form.submit()" class="cursor-pointer rounded-lg border-none px-3 py-1.5 text-xs font-bold focus:ring-2 focus:ring-secondary/50" style="background:#F8FAFC; color:#1E3A5F;">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" @selected((int) $year === (int) $selectedYear)>{{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div style="height:320px;">
                    <canvas id="laporanBarChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-slate-100 p-8 card-shadow">
                <h3 class="text-xl font-bold" style="color:#1E3A5F;">Distribusi Prodi</h3>
                <p class="text-xs font-medium mb-8" style="color:#64748B;">Peminat per program studi</p>

                <div class="relative flex items-center justify-center" style="height:220px;">
                    <canvas id="laporanPieChart"></canvas>
                    <div class="pointer-events-none absolute flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold" style="color:#1E3A5F;">{{ $programCount }}</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest" style="color:#94a3b8;">Jurusan</span>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach($pieData as $item)
                        @if(($item['count'] ?? 0) > 0)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $item['color'] }};"></span>
                                    <span class="text-sm font-medium" style="color:#64748B;">{{ $item['name'] }}</span>
                                </div>
                                <span class="text-sm font-bold" style="color:#1E3A5F;">{{ $item['count'] }} / {{ $item['value'] }}%</span>
                            </div>
                        @endif
                    @endforeach
                    @if($pieData->where('count', '>', 0)->isEmpty())
                        <p class="rounded-2xl bg-slate-50 p-4 text-sm font-semibold" style="color:#64748B;">Belum ada data peminat program studi.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[28px] border border-slate-100 p-8 card-shadow">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h3 class="text-xl font-bold" style="color:#1E3A5F;">Peringkat Asal Sekolah</h3>
                    <p class="text-xs font-medium" style="color:#64748B;">Sekolah dengan kontribusi pendaftar terbanyak</p>
                </div>
                <button type="button" class="flex cursor-pointer items-center gap-2 text-sm font-bold transition-all hover:translate-x-0.5 hover:brightness-95 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="color:#F0A500;">
                    Lihat Semua Sekolah
                    <i class="bi bi-arrow-up-right"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($schools as $school)
                    <div class="group flex items-center justify-between p-4 rounded-2xl bg-slate-50 lift-hover">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 flex items-center justify-center rounded-xl font-bold" style="background:#fff; color:#1E3A5F;">
                                {{ $school['id'] }}
                            </span>
                            <div>
                                <h5 class="text-sm font-bold" style="color:#1E3A5F;">{{ $school['name'] }}</h5>
                                <p class="text-[11px] uppercase font-medium" style="color:#94a3b8;">{{ $school['location'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black" style="color:#1E3A5F;">{{ $school['count'] }}</p>
                            <p class="text-[9px] uppercase font-bold" style="color:#94a3b8;">Siswa</p>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 rounded-2xl bg-slate-50 p-6 text-sm font-semibold" style="color:#64748B;">
                        Belum ada data asal sekolah pada tahun laporan ini.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-12 p-8 rounded-[32px] text-white relative overflow-hidden" style="background:#1A2744;">
            <div class="pointer-events-none absolute -bottom-24 -right-24 w-64 h-64 rounded-full" style="background:rgba(240,165,0,0.2); filter: blur(100px);"></div>
            <div class="pointer-events-none absolute -top-12 -left-12 w-48 h-48 rounded-full" style="background:rgba(30,58,95,0.4); filter: blur(80px);"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div class="max-w-md">
                    <h4 class="text-2xl font-bold mb-2">Unduh Laporan Komprehensif</h4>
                    <p class="text-sm" style="color:rgba(255,255,255,0.7);">
                        Dapatkan rangkuman data pendaftaran lengkap dalam format yang Anda butuhkan (PDF/Excel).
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <span aria-disabled="true" class="flex cursor-not-allowed items-center gap-2 rounded-2xl px-5 py-3 text-sm font-bold opacity-60" style="background:#fff; color:#1E3A5F;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                        PDF Segera Tersedia
                    </span>
                    <span aria-disabled="true" class="flex cursor-not-allowed items-center gap-2 rounded-2xl px-5 py-3 text-sm font-bold opacity-60" style="background:#F0A500; color:#1A2744;">
                        <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                        Excel Segera Tersedia
                    </span>
                    <button type="button" disabled aria-disabled="true" class="flex cursor-not-allowed items-center gap-2 rounded-2xl px-5 py-3 text-sm font-bold opacity-60" style="background:rgba(30,58,95,0.5); border:1px solid rgba(255,255,255,0.2);">
                        <i class="bi bi-envelope-fill"></i>
                        Email Segera Tersedia
                    </button>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            const barData = @json($barData);
            const pieData = @json($pieData);

            const barCtx = document.getElementById('laporanBarChart');
            if (barCtx) {
                const maxValue = Math.max(...barData.map(item => item.value));
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: barData.map(item => item.name),
                        datasets: [
                            {
                                data: barData.map(item => item.value),
                                backgroundColor: barData.map(item => {
                                    if (item.isCurrent) return '#F0A500';
                                    if (item.isFuture) return 'rgba(148, 163, 184, 0.35)';
                                    return 'rgba(2, 36, 72, 0.35)';
                                }),
                                borderRadius: 10,
                                borderSkipped: false,
                                barThickness: 36,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1A2744',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                displayColors: false,
                                callbacks: {
                                    label: (ctx) => `${ctx.parsed.y.toLocaleString()} Pendaftar`,
                                    title: () => '',
                                },
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: { color: '#94a3b8', font: { size: 11, weight: '700' } }
                            },
                            y: {
                                display: false,
                                beginAtZero: true,
                                suggestedMax: maxValue * 1.2,
                                grid: { display: false },
                                border: { display: false },
                            }
                        }
                    }
                });
            }

            const pieCtx = document.getElementById('laporanPieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: pieData.map(item => item.name),
                        datasets: [
                            {
                                data: pieData.map(item => item.value),
                                backgroundColor: pieData.map(item => item.color),
                                borderWidth: 0,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1A2744',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                displayColors: false,
                            }
                        }
                    }
                });
            }
        </script>
    @endpush
@endsection
