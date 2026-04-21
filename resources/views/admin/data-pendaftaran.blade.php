@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'data-pendaftaran'])
    @include('admin.partials.topbar', ['showSearch' => true])

    <main style="margin-left:260px; padding-top:64px;" class="p-8 pb-12 space-y-8 page-animate">
                <div class="flex items-end justify-between">
                    <div class="space-y-1">
                        <h2 class="text-4xl font-headline font-extrabold tracking-tight" style="color:#1E3A5F;">Data Pendaftaran</h2>
                        <p class="text-slate-500 font-medium">Kelola seluruh data pendaftaran mahasiswa baru.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('admin.data-pendaftaran.export.excel', request()->query()) }}"
                            class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl font-headline font-bold text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm"
                            style="color:#1E3A5F;"
                        >
                            <i class="bi bi-file-earmark-spreadsheet" style="color:#F0A500;"></i>
                            Export Excel
                        </a>
                        <a
                            href="{{ route('admin.data-pendaftaran.export.pdf', request()->query()) }}"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-headline font-bold text-sm text-white hover:opacity-90 hover:shadow-lg transition-all shadow-md"
                            style="background-color:#1E3A5F;"
                        >
                            <i class="bi bi-file-earmark-pdf"></i>
                            Export PDF
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/50">
                    <form method="GET" action="{{ route('admin.data-pendaftaran') }}" class="grid grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Status Pendaftaran</label>
                            <select name="status" class="w-full h-11 bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 transition-all cursor-pointer">
                                @foreach (['Semua Status', 'Diverifikasi', 'Menunggu', 'Ditolak'] as $option)
                                    <option value="{{ $option === 'Semua Status' ? '' : $option }}" {{ request('status') === ($option === 'Semua Status' ? '' : $option) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Program Studi</label>
                            <select name="prodi" class="w-full h-11 bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 transition-all cursor-pointer">
                                @foreach (['Semua Prodi', 'Teknik Informatika', 'Sistem Informasi', 'Manajemen'] as $option)
                                    <option value="{{ $option === 'Semua Prodi' ? '' : $option }}" {{ request('prodi') === ($option === 'Semua Prodi' ? '' : $option) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Gelombang</label>
                            <select name="gelombang" class="w-full h-11 bg-slate-50 border-none rounded-xl text-sm font-semibold text-slate-700 transition-all cursor-pointer">
                                @foreach (['Semua Gelombang', 'Gelombang 1', 'Gelombang 2', 'Gelombang 3'] as $option)
                                    <option value="{{ $option === 'Semua Gelombang' ? '' : $option }}" {{ request('gelombang') === ($option === 'Semua Gelombang' ? '' : $option) ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full h-11 text-white font-headline font-extrabold text-sm rounded-xl hover:opacity-90 transition-all shadow-lg active:scale-[0.98]" style="background-color:#F0A500;">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    @foreach (['ID', 'Nama Mahasiswa', 'Program Studi', 'Gelombang', 'Status', 'Aksi'] as $header)
                                        <th class="px-6 py-5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($pendaftaran as $row)
                                    @php
                                        $avatar = $row->user && $row->user->foto
                                            ? asset('storage/' . $row->user->foto)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($row->user?->nama_lengkap ?? $row->nama_lengkap) . '&background=random';
                                        $badgeClass = match($row->status) {
                                            'Diverifikasi' => 'bg-green-50 text-green-600 border border-green-100',
                                            'Menunggu' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                            'Ditolak' => 'bg-red-50 text-red-600 border border-red-100',
                                            default => 'bg-slate-50 text-slate-600 border border-slate-100',
                                        };
                                    @endphp
                                    <tr class="group hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-5">
                                            <span class="font-headline font-bold" style="color:#1E3A5F;">{{ $row->no_pendaftaran ?? ('#PMB' . str_pad($row->id, 4, '0', STR_PAD_LEFT)) }}</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <img
                                                    src="{{ $avatar }}"
                                                    alt="{{ $row->user?->nama_lengkap ?? $row->nama_lengkap }}"
                                                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm"
                                                />
                                                <div>
                                                    <p class="font-headline font-bold text-slate-800 text-sm">{{ $row->user?->nama_lengkap ?? $row->nama_lengkap }}</p>
                                                    <p class="text-slate-400 text-xs font-medium">{{ $row->user?->email ?? $row->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $row->prodi->nama_prodi }}</td>
                                        <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $row->gelombang->nama_gelombang }}</td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm inline-block {{ $badgeClass }}">
                                                {{ $row->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <button class="p-2 text-slate-400 transition-colors hover:bg-slate-100 rounded-lg active:scale-[0.9]" style="color:#94a3b8;">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @include('admin.partials.pagination', ['paginator' => $pendaftaran])
                </div>

                <div class="grid grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/50 flex items-center gap-5 group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500 text-white shadow-lg" style="background-color:#1E3A5F;">
                            <i class="bi bi-people-fill text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pendaftar</p>
                            <h3 class="text-3xl font-headline font-black -mt-0.5" style="color:#1E3A5F;">{{ number_format($totalPendaftar) }}</h3>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/50 flex items-center gap-5 group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500 bg-green-500 text-white shadow-lg shadow-green-200">
                            <i class="bi bi-clipboard-check-fill text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Telah Diverifikasi</p>
                            <h3 class="text-3xl font-headline font-black -mt-0.5" style="color:#1E3A5F;">{{ number_format($totalDiverifikasi) }}</h3>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/50 flex items-center gap-5 group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500 text-white shadow-lg" style="background-color:#F0A500;">
                            <i class="bi bi-clock-fill text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu Verifikasi</p>
                            <h3 class="text-3xl font-headline font-black -mt-0.5" style="color:#1E3A5F;">{{ number_format($totalMenunggu) }}</h3>
                        </div>
                    </div>
                </div>
    </main>
@endsection
