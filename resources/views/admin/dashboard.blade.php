@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'dashboard'])
    @include('admin.partials.topbar')

    <main style="margin-left:260px; padding-top:64px;">
        <div class="p-8 max-w-7xl w-full mx-auto space-y-8">
                <script>
                    const chartData = @json($chartData);
                </script>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <span>Admin</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="font-bold" style="color:#1E3A5F;">Dashboard</span>
                    </div>
                    <h2 class="text-3xl font-headline font-extrabold tracking-tight" style="color:#1E3A5F;">Dashboard Admin</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-white p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300" style="background-color:#1a2744;">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold mb-1 text-blue-100/70">Total Pendaftar</p>
                            <h3 class="text-3xl font-extrabold tracking-tight">{{ number_format($stats['total_pendaftar']) }}</h3>
                            <div class="mt-4 flex items-center gap-2 text-[11px] font-medium text-white/60">
                                <i class="bi bi-graph-up-arrow"></i>
                                <span>{{ $stats['trend_persen'] }} dari bulan lalu</span>
                            </div>
                        </div>
                        <i class="bi bi-people-fill pointer-events-none absolute -right-4 -bottom-4 w-28 h-28 text-white/20 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6"></i>
                    </div>

                    <div class="p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300" style="background-color:#F0A500; color:#1a2744;">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold mb-1" style="color:rgba(26,39,68,0.7);">Pendaftar Hari Ini</p>
                            <h3 class="text-3xl font-extrabold tracking-tight">{{ $stats['pendaftar_hari_ini'] }}</h3>
                            <div class="mt-4 flex items-center gap-2 text-[11px] font-medium" style="color:rgba(26,39,68,0.6);">
                                <i class="bi bi-clock"></i>
                                <span>Update: {{ $stats['last_update'] }}</span>
                            </div>
                        </div>
                        <i class="bi bi-clock pointer-events-none absolute -right-4 -bottom-4 w-28 h-28 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6" style="color:rgba(26,39,68,0.1);"></i>
                    </div>

                    <div class="bg-white border border-green-100 text-slate-800 shadow-sm p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold mb-1 text-slate-400">Sudah Diverifikasi</p>
                            <h3 class="text-3xl font-extrabold tracking-tight text-green-500">{{ $stats['sudah_diverifikasi'] }}</h3>
                            <div class="mt-4 flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                <i class="bi bi-check-circle-fill text-green-500"></i>
                                <span>{{ $stats['persen_diverifikasi'] }} dari total pendaftar</span>
                            </div>
                        </div>
                        <i class="bi bi-check-circle-fill pointer-events-none absolute -right-4 -bottom-4 w-28 h-28 text-green-500/10 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6"></i>
                    </div>

                    <div class="bg-white border border-red-100 text-slate-800 shadow-sm p-6 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold mb-1 text-slate-400">Ditolak / Perlu Perbaikan</p>
                            <h3 class="text-3xl font-extrabold tracking-tight text-red-500">{{ $stats['ditolak'] }}</h3>
                            <div class="mt-4 flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                <i class="bi bi-x-circle-fill text-red-500"></i>
                                <span>Memerlukan tindak lanjut</span>
                            </div>
                        </div>
                        <i class="bi bi-x-circle-fill pointer-events-none absolute -right-4 -bottom-4 w-28 h-28 text-red-500/10 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col gap-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xl font-headline font-bold" style="color:#1E3A5F;">Grafik Pendaftaran 7 Hari Terakhir</h4>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full" style="background-color:#1E3A5F;"></div>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400">Pendaftar</span>
                            </div>
                        </div>

                        <div class="flex items-end justify-between h-56 px-2 border-b border-slate-100 relative">
                            @foreach ($chartData as $index => $height)
                                <div class="flex flex-col items-center gap-3 w-full group" style="--bar-index: {{ $index }};">
                                    <div
                                        class="w-10 rounded-t-lg transition-colors relative bar-animate"
                                        style="--bar-height: {{ $height }}%; height: 0; animation-delay: calc(var(--bar-index) * 0.1s); background-color:#1E3A5F;"
                                        title="{{ $height }}%"
                                    >
                                        <div class="pointer-events-none absolute -top-8 left-1/2 -translate-x-1/2 rounded px-2 py-1 text-[10px] text-white opacity-0 transition-opacity group-hover:opacity-100" style="background-color:#1a2744;">
                                            {{ $height }}
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'][$index] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-8 rounded-3xl text-white flex flex-col justify-between relative overflow-hidden shadow-xl" style="background-color:#1a2744;">
                        <div class="relative z-10 space-y-4">
                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest shadow-sm" style="background-color:#F0A500; color:#1a2744;">
                                Priority Notice
                            </span>
                            <h4 class="text-2xl font-headline font-bold leading-tight">Verifikasi Berkas Masuk</h4>
                            <p class="text-blue-100/60 text-xs leading-relaxed font-medium">
                                Terdapat 18 berkas pendaftaran baru yang memerlukan validasi manual segera hari ini.
                            </p>
                            <a href="{{ route('admin.data-pendaftaran') }}" class="group flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3.5 font-bold shadow-lg transition-all hover:-translate-y-0.5 hover:brightness-105 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="background-color:#F0A500; color:#1a2744;">
                                Mulai Verifikasi
                                <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        <div class="pointer-events-none absolute -right-8 -top-8 opacity-5">
                            <i class="bi bi-file-text" style="font-size: 200px;"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-12">
                    <div class="p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h4 class="text-xl font-headline font-bold" style="color:#1E3A5F;">Pendaftaran Terbaru</h4>
                            <p class="text-slate-400 text-xs font-medium mt-1">Data 5 pendaftar terakhir masuk ke sistem</p>
                        </div>
                        <a href="{{ route('admin.data-pendaftaran') }}" class="group flex cursor-pointer items-center gap-2 whitespace-nowrap text-xs font-extrabold uppercase tracking-widest transition-all hover:text-yellow-500 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="color:#1E3A5F;">
                            Lihat Semua
                            <div class="p-1.5 bg-slate-100 rounded-lg transition-colors" style="color:#1E3A5F;">
                                <i class="bi bi-arrow-right text-sm"></i>
                            </div>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 text-[10px] uppercase font-extrabold tracking-widest border-y border-slate-100">
                                    <th class="px-8 py-4">ID Pendaftaran</th>
                                    <th class="px-8 py-4">Nama Lengkap</th>
                                    <th class="px-8 py-4">Program Studi</th>
                                    <th class="px-8 py-4">Asal Sekolah</th>
                                    <th class="px-8 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($pendaftaranTerbaru as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-8 py-5 text-sm font-bold" style="color:#1E3A5F;">{{ $row->id_pendaftaran ?? ('#PMB' . str_pad($row->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                @php
                                                    $initials = strtoupper(substr($row->nama_lengkap, 0, 1)) . strtoupper(substr(strrchr($row->nama_lengkap, ' ') ?: $row->nama_lengkap, 1, 1));
                                                    $avatarClasses = match($loop->index % 3) {
                                                        0 => 'bg-blue-100 text-blue-600',
                                                        1 => 'bg-yellow-100 text-yellow-600',
                                                        default => 'bg-purple-100 text-purple-600',
                                                    };
                                                @endphp
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[10px] {{ $avatarClasses }}">
                                                    {{ $initials }}
                                                </div>
                                                <span class="text-sm font-bold text-slate-700">{{ $row->nama_lengkap }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-[13px] text-slate-500 font-medium">{{ $row->program_studi ?? '-' }}</td>
                                        <td class="px-8 py-5 text-[13px] text-slate-500 font-medium">{{ $row->asal_sekolah ?? '-' }}</td>
                                        <td class="px-8 py-5">
                                            @switch($row->status)
                                                @case('Menunggu')
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider border bg-yellow-50 text-yellow-600 border-yellow-100">Menunggu</span>
                                                @break
                                                @case('Diverifikasi')
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider border bg-green-50 text-green-600 border-green-100">Diverifikasi</span>
                                                @break
                                                @case('Ditolak')
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider border bg-red-50 text-red-600 border-red-100">Ditolak</span>
                                                @break
                                                @default
                                                    <span class="px-3 py-1 rounded-full text-[9px] font-extrabold uppercase tracking-wider border bg-yellow-50 text-yellow-600 border-yellow-100">Menunggu</span>
                                            @endswitch
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <button type="button" class="cursor-pointer rounded-lg p-2 text-slate-300 transition-all hover:bg-slate-100 hover:text-slate-900 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </main>
@endsection
