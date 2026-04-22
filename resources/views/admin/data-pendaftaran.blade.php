@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'data-pendaftaran'])
    @include('admin.partials.topbar', ['showSearch' => true])

    <main class="admin-main-shell space-y-8 page-animate">
                <div class="flex items-end justify-between">
                    <div class="space-y-1">
                        <h2 class="text-4xl font-headline font-extrabold tracking-tight" style="color:#1E3A5F;">Data Pendaftaran</h2>
                        <p class="text-slate-500 font-medium">Kelola seluruh data pendaftaran mahasiswa baru.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('admin.data-pendaftaran.export.excel', request()->query()) }}"
                            class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold shadow-sm transition-all hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70"
                            style="color:#1E3A5F;"
                        >
                            <i class="bi bi-file-earmark-spreadsheet" style="color:#F0A500;"></i>
                            Export Excel
                        </a>
                        <a
                            href="{{ route('admin.data-pendaftaran.export.pdf', request()->query()) }}"
                            class="flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:opacity-90 hover:shadow-lg active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70"
                            style="background-color:#1E3A5F;"
                        >
                            <i class="bi bi-file-earmark-pdf"></i>
                            Export PDF
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/50">
                    @if (session('success'))
                        <div class="mb-5 rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm font-bold text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('admin.data-pendaftaran') }}" class="grid grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Status Pendaftaran</label>
                            <select name="status" class="h-11 w-full cursor-pointer rounded-xl border-none bg-slate-50 text-sm font-semibold text-slate-700 transition-all hover:bg-slate-100 focus:bg-white focus:ring-2 focus:ring-secondary/50">
                                @foreach (['' => 'Semua Status'] + collect(\App\Support\StudentStatusPresenter::labels())->except('terkirim')->all() as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Program Studi</label>
                            <select name="prodi" class="h-11 w-full cursor-pointer rounded-xl border-none bg-slate-50 text-sm font-semibold text-slate-700 transition-all hover:bg-slate-100 focus:bg-white focus:ring-2 focus:ring-secondary/50">
                                <option value="">Semua Prodi</option>
                                @foreach ($programStudi as $program)
                                    <option value="{{ $program->id }}" {{ (string) request('prodi') === (string) $program->id ? 'selected' : '' }}>
                                        {{ trim(($program->jenjang ? $program->jenjang . ' ' : '') . $program->nama) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Gelombang</label>
                            <select name="gelombang" class="h-11 w-full cursor-pointer rounded-xl border-none bg-slate-50 text-sm font-semibold text-slate-700 transition-all hover:bg-slate-100 focus:bg-white focus:ring-2 focus:ring-secondary/50">
                                <option value="">Semua Gelombang</option>
                                @foreach ($gelombangPendaftaran as $gelombang)
                                    <option value="{{ $gelombang->id }}" {{ (string) request('gelombang') === (string) $gelombang->id ? 'selected' : '' }}>
                                        {{ $gelombang->nama }} - {{ $gelombang->tahun_akademik }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="h-11 w-full cursor-pointer rounded-xl text-sm font-extrabold text-white shadow-lg transition-all hover:-translate-y-0.5 hover:opacity-90 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="background-color:#F0A500;">
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
                                    @foreach (['Nomor Pendaftaran', 'Nama Mahasiswa', 'Program Studi', 'Gelombang', 'Status', 'Aksi'] as $header)
                                        <th class="px-6 py-5 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($pendaftaran as $row)
                                    @php
                                        $displayName = $row->full_name ?: $row->user?->name ?: 'Calon Mahasiswa';
                                        $displayEmail = $row->email ?: $row->user?->email;
                                        $program = $row->relationLoaded('programStudi') ? $row->getRelation('programStudi') : $row->programStudi()->first();
                                        $gelombang = $row->relationLoaded('gelombangPendaftaran') ? $row->getRelation('gelombangPendaftaran') : $row->gelombangPendaftaran()->first();
                                        $avatar = $row->user && $row->user->foto
                                            ? asset('storage/' . $row->user->foto)
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=1E3A5F&color=fff&bold=true';
                                        $badgeClass = match($row->status) {
                                            'verified', 'accepted' => 'bg-green-50 text-green-600 border border-green-100',
                                            'submitted', 'under_review' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                            'documents_uploaded' => 'bg-blue-50 text-blue-600 border border-blue-100',
                                            'revision_required' => 'bg-orange-50 text-orange-600 border border-orange-100',
                                            'rejected' => 'bg-red-50 text-red-600 border border-red-100',
                                            default => 'bg-slate-50 text-slate-600 border border-slate-100',
                                        };
                                        $statusLabel = \App\Support\StudentStatusPresenter::label($row->status);
                                    @endphp
                                    <tr class="group hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-5">
                                            <span class="font-headline font-bold" style="color:#1E3A5F;">{{ $row->nomor_pendaftaran ?? ('PMB-' . str_pad($row->id, 5, '0', STR_PAD_LEFT)) }}</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-3">
                                                <img
                                                    src="{{ $avatar }}"
                                                    alt="{{ $displayName }}"
                                                    class="w-10 h-10 rounded-full border-2 border-white shadow-sm"
                                                />
                                                <div>
                                                    <p class="font-headline font-bold text-slate-800 text-sm">{{ $displayName }}</p>
                                                    <p class="text-slate-400 text-xs font-medium">{{ $displayEmail ?: '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-semibold text-slate-600">
                                            {{ $program ? trim(($program->jenjang ? $program->jenjang . ' ' : '') . $program->nama) : '-' }}
                                        </td>
                                        <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $gelombang?->nama ?? '-' }}</td>
                                        <td class="px-6 py-5">
                                            <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm inline-block {{ $badgeClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <a href="{{ route('admin.data-pendaftaran.show', $row) }}" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2 text-xs font-black uppercase tracking-wider text-white transition-all hover:-translate-y-0.5 hover:opacity-90 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                                <i class="bi bi-eye-fill"></i>
                                                Lihat Detail
                                            </a>
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
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu Review</p>
                            <h3 class="text-3xl font-headline font-black -mt-0.5" style="color:#1E3A5F;">{{ number_format($totalMenunggu) }}</h3>
                        </div>
                    </div>
                </div>
    </main>
@endsection
