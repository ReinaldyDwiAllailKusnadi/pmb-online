@extends('layouts.admin')

@php
    $program = $pendaftaran->relationLoaded('programStudi') ? $pendaftaran->getRelation('programStudi') : $pendaftaran->programStudi()->first();
    $gelombang = $pendaftaran->relationLoaded('gelombangPendaftaran') ? $pendaftaran->getRelation('gelombangPendaftaran') : $pendaftaran->gelombangPendaftaran()->first();
    $displayName = $pendaftaran->full_name ?: $pendaftaran->user?->name ?: 'Calon Mahasiswa';
    $displayEmail = $pendaftaran->email ?: $pendaftaran->user?->email;
    $nomorPendaftaran = $pendaftaran->nomor_pendaftaran ?? ('PMB-' . str_pad((string) $pendaftaran->id, 5, '0', STR_PAD_LEFT));
    $statusLabels = \App\Support\StudentStatusPresenter::labels();
    $badgeClass = match($pendaftaran->status) {
        'verified', 'accepted' => 'bg-green-50 text-green-600 border border-green-100',
        'submitted', 'under_review' => 'bg-amber-50 text-amber-600 border border-amber-100',
        'documents_uploaded' => 'bg-blue-50 text-blue-600 border border-blue-100',
        'revision_required' => 'bg-orange-50 text-orange-600 border border-orange-100',
        'rejected' => 'bg-red-50 text-red-600 border border-red-100',
        default => 'bg-slate-50 text-slate-600 border border-slate-100',
    };
    $canStartReview = $pendaftaran->status === 'submitted';
    $canDecide = $pendaftaran->status === 'under_review';
    $disabledButtonClass = 'opacity-50 cursor-not-allowed hover:translate-y-0 hover:opacity-50 active:scale-100';
    $enabledButtonClass = 'cursor-pointer hover:-translate-y-0.5 active:scale-[0.98]';
@endphp

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'data-pendaftaran'])
    @include('admin.partials.topbar', ['showSearch' => false])

    <main class="admin-main-shell space-y-8 page-animate">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.data-pendaftaran') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition-all hover:text-primary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Data Pendaftaran
                </a>
                <h2 class="text-4xl font-headline font-extrabold tracking-tight" style="color:#1E3A5F;">Detail Pendaftaran</h2>
                <p class="mt-1 text-slate-500 font-medium">Tinjau data mahasiswa dan lakukan keputusan review dari halaman ini.</p>
            </div>
            <div class="rounded-2xl bg-white px-6 py-4 text-right shadow-sm border border-slate-200/50">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor Pendaftaran</p>
                <p class="mt-1 text-lg font-black text-primary">{{ $nomorPendaftaran }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm font-bold text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-12 gap-8">
            <section class="col-span-12 xl:col-span-8 space-y-8">
                <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200/50">
                    <div class="mb-6 flex items-start justify-between gap-6">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Status Saat Ini</p>
                            <div class="mt-3 flex flex-wrap items-center gap-3">
                                <h3 class="text-2xl font-black text-primary">{{ $displayName }}</h3>
                                <span class="rounded-full px-3 py-1.5 text-[10px] font-black uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $statusLabels[$pendaftaran->status] ?? ucfirst((string) $pendaftaran->status) }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm font-semibold text-slate-500">{{ $displayEmail ?: '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Submitted</p>
                            <p class="mt-1 text-sm font-bold text-primary">{{ $pendaftaran->submitted_at ? \Carbon\Carbon::parse($pendaftaran->submitted_at)->translatedFormat('d F Y, H:i') : '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ([
                            'Nama Lengkap' => $displayName,
                            'Email' => $displayEmail ?: '-',
                            'Telepon' => $pendaftaran->phone ?: '-',
                            'Tempat Lahir' => $pendaftaran->birth_place ?: '-',
                            'Tanggal Lahir' => trim(($pendaftaran->birth_day ?: '-') . ' ' . ($pendaftaran->birth_month ?: '') . ' ' . ($pendaftaran->birth_year ?: '')),
                            'Jenis Kelamin' => $pendaftaran->gender ?: '-',
                            'Kewarganegaraan' => $pendaftaran->citizen ?: '-',
                            'Agama' => $pendaftaran->religion ?: '-',
                        ] as $label => $value)
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $label }}</p>
                                <p class="mt-2 text-sm font-bold text-slate-700">{{ $value }}</p>
                            </div>
                        @endforeach
                        <div class="rounded-2xl bg-slate-50 p-5 md:col-span-2">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Alamat KTP</p>
                            <p class="mt-2 text-sm font-bold leading-relaxed text-slate-700">{{ $pendaftaran->address ?: '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5 md:col-span-2">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Alamat Domisili</p>
                            <p class="mt-2 text-sm font-bold leading-relaxed text-slate-700">{{ $pendaftaran->current_address ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200/50">
                    <h3 class="mb-6 text-xl font-black text-primary">Data Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Program Studi</p>
                            <p class="mt-2 text-sm font-bold text-slate-700">{{ $program ? trim(($program->jenjang ? $program->jenjang . ' ' : '') . $program->nama) : '-' }}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ $program?->fakultas ?: '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Gelombang</p>
                            <p class="mt-2 text-sm font-bold text-slate-700">{{ $gelombang?->nama ?: '-' }}</p>
                            <p class="mt-1 text-xs font-semibold text-slate-500">{{ $gelombang?->tahun_akademik ?: '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Sekolah</p>
                            <p class="mt-2 text-sm font-bold text-slate-700">{{ $pendaftaran->asal_sekolah ?: '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Verifikasi</p>
                            <p class="mt-2 text-sm font-bold text-slate-700">{{ $pendaftaran->verified_at ? \Carbon\Carbon::parse($pendaftaran->verified_at)->translatedFormat('d F Y, H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200/50">
                    <h3 class="mb-6 text-xl font-black text-primary">Dokumen Terunggah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ($documents as $document)
                            @php
                                $exists = filled($document['path']) && (
                                    \Illuminate\Support\Facades\Storage::disk('local')->exists($document['path'])
                                    || \Illuminate\Support\Facades\Storage::disk('public')->exists($document['path'])
                                );
                            @endphp
                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-black text-primary">{{ $document['label'] }}</p>
                                        <p class="mt-1 text-xs font-semibold text-slate-500">{{ $document['path'] ? basename($document['path']) : 'Belum diunggah' }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-[10px] font-black {{ $exists ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                        {{ $exists ? 'Ada' : 'Tidak Ada' }}
                                    </span>
                                </div>
                                @if ($exists)
                                    <a href="{{ route('admin.data-pendaftaran.dokumen.show', [$pendaftaran, $document['key']]) }}" target="_blank" class="mt-4 inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-primary transition-all hover:underline">
                                        <i class="bi bi-file-earmark-text"></i>
                                        Lihat Dokumen
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <aside class="col-span-12 xl:col-span-4 space-y-8">
                <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200/50">
                    <h3 class="text-xl font-black text-primary">Review Admin</h3>
                    <p class="mt-2 text-sm font-medium leading-relaxed text-slate-500">Keputusan review akan langsung terlihat pada halaman status calon mahasiswa.</p>

                    @if ($pendaftaran->catatan_admin)
                        <div class="mt-6 rounded-2xl border-l-4 border-secondary bg-amber-50 p-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-amber-700">Catatan Admin</p>
                            <p class="mt-2 text-sm font-semibold leading-relaxed text-amber-900">{{ $pendaftaran->catatan_admin }}</p>
                        </div>
                    @endif

                    <div class="mt-6 space-y-4">
                        <form method="POST" action="{{ route('admin.data-pendaftaran.mark-under-review', $pendaftaran) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="catatan_admin" value="Pendaftaran mulai ditinjau oleh admin.">
                            <button type="submit" @disabled(! $canStartReview) class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3 text-xs font-black uppercase tracking-wider text-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70 {{ $canStartReview ? $enabledButtonClass . ' hover:opacity-90' : $disabledButtonClass }}">
                                <i class="bi bi-hourglass-split"></i>
                                Mulai Review
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.data-pendaftaran.verify', $pendaftaran) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="catatan_admin" value="Pendaftaran telah diverifikasi oleh admin.">
                            <button type="submit" @disabled(! $canDecide) class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-xs font-black uppercase tracking-wider text-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-300 {{ $canDecide ? $enabledButtonClass . ' hover:bg-green-700' : $disabledButtonClass }}">
                                <i class="bi bi-patch-check-fill"></i>
                                Verifikasi / ACC
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.data-pendaftaran.request-revision', $pendaftaran) }}" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <textarea name="catatan_admin" rows="3" required @disabled(! $canDecide) placeholder="Catatan revisi untuk calon mahasiswa" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-amber-300 focus:bg-white focus:ring-2 focus:ring-amber-100 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                            <button type="submit" @disabled(! $canDecide) class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-xs font-black uppercase tracking-wider text-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 {{ $canDecide ? $enabledButtonClass . ' hover:bg-amber-600' : $disabledButtonClass }}">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                Minta Revisi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.data-pendaftaran.reject', $pendaftaran) }}" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <textarea name="catatan_admin" rows="3" required @disabled(! $canDecide) placeholder="Alasan penolakan" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-red-300 focus:bg-white focus:ring-2 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                            <button type="submit" @disabled(! $canDecide) class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-xs font-black uppercase tracking-wider text-white transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-300 {{ $canDecide ? $enabledButtonClass . ' hover:bg-red-700' : $disabledButtonClass }}">
                                <i class="bi bi-x-circle-fill"></i>
                                Tolak
                            </button>
                        </form>
                    </div>

                    @if (! $canStartReview && ! $canDecide)
                        <p class="mt-5 rounded-xl bg-slate-50 p-4 text-xs font-semibold leading-relaxed text-slate-500">
                            Aksi review aktif hanya untuk status Menunggu Review Admin atau Sedang Diverifikasi.
                        </p>
                    @endif
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-sm border border-slate-200/50">
                    <h3 class="mb-6 text-xl font-black text-primary">Timeline Status</h3>
                    @if ($histories->isEmpty())
                        <p class="rounded-2xl bg-slate-50 p-5 text-sm font-semibold text-slate-500">Belum ada riwayat perubahan status.</p>
                    @else
                        <div class="space-y-5">
                            @foreach ($histories as $history)
                                <div class="relative border-l-2 border-slate-100 pl-5">
                                    <span class="absolute -left-[7px] top-1 h-3 w-3 rounded-full bg-secondary ring-4 ring-amber-50"></span>
                                    <p class="text-sm font-black text-primary">
                                        {{ $statusLabels[$history->status_from] ?? ucfirst((string) $history->status_from) }}
                                        <i class="bi bi-arrow-right mx-1 text-slate-300"></i>
                                        {{ $statusLabels[$history->status_to] ?? ucfirst((string) $history->status_to) }}
                                    </p>
                                    <p class="mt-1 text-xs font-semibold text-slate-400">
                                        {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d F Y, H:i') }}
                                        @if ($history->actor_name)
                                            oleh {{ $history->actor_name }}
                                        @endif
                                    </p>
                                    @if ($history->catatan)
                                        <p class="mt-2 text-xs font-medium leading-relaxed text-slate-600">{{ $history->catatan }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </main>
@endsection
