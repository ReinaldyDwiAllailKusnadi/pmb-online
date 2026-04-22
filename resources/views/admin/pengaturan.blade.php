@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'pengaturan', 'adminProfile' => $admin])
    @include('admin.partials.topbar', [
        'placeholder' => 'Cari pengaturan...',
        'adminName' => 'Direktorat TIK',
        'adminRole' => 'SUPERADMIN',
    ])

    <main class="admin-main-shell page-animate">
            <section class="fade-up mb-12">
                <h2 class="text-4xl font-black tracking-tight text-primary">Pengaturan Sistem</h2>
                <p class="mt-2 max-w-3xl font-medium leading-relaxed text-slate-500">
                    Konfigurasi identitas institusi, parameter pendaftaran, dan standarisasi operasional PMB Gateway.
                </p>
            </section>

            @if (session('success'))
                <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-bold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <section class="grid grid-cols-12 gap-10">
                <aside class="col-span-4 space-y-8">
                    <div class="rounded-2xl bg-slate-100/80 p-4 shadow-sm shadow-slate-200/40">
                        <h3 class="px-4 py-3 text-[11px] font-black uppercase tracking-[0.25em] text-slate-500">Kategori Utama</h3>
                        <div class="space-y-1">
                            @foreach ($settingCategories['utama'] as $item)
                                @php $isActive = $item['active'] ?? false; @endphp
                                <a href="#{{ $item['key'] }}"
                                   class="{{ $isActive ? 'bg-white shadow-xl shadow-slate-200/70 ring-1 ring-slate-100' : 'text-slate-500 hover:bg-white hover:shadow-lg hover:shadow-slate-200/50 active:scale-[0.98]' }} group flex cursor-pointer items-center justify-between rounded-2xl px-5 py-5 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                    <span class="flex items-center gap-4">
                                        <span class="{{ $isActive ? 'bg-secondary/10 text-secondary' : 'text-slate-600 group-hover:bg-slate-100 group-hover:text-primary' }} flex h-8 w-8 items-center justify-center rounded-lg transition-colors">
                                            <i class="bi {{ $item['icon'] }} text-xl leading-none"></i>
                                        </span>
                                        <span class="{{ $isActive ? 'text-primary' : 'text-slate-500 group-hover:text-primary' }} text-[13px] font-black uppercase tracking-wider">
                                            {{ $item['label'] }}
                                        </span>
                                    </span>
                                    <i class="bi bi-chevron-right {{ $isActive ? 'text-primary opacity-100' : 'text-slate-300 opacity-0 group-hover:translate-x-1 group-hover:opacity-100' }} text-sm transition-all"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-100/80 p-4 shadow-sm shadow-slate-200/40">
                        <h3 class="px-4 py-3 text-[11px] font-black uppercase tracking-[0.25em] text-slate-500">Integrasi</h3>
                        <div class="space-y-1">
                            @foreach ($settingCategories['integrasi'] as $item)
                                <a href="#{{ $item['key'] }}"
                                   class="group flex cursor-pointer items-center justify-between rounded-2xl px-5 py-5 text-slate-500 transition-all hover:bg-white hover:shadow-lg hover:shadow-slate-200/50 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                    <span class="flex items-center gap-4">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-600 transition-colors group-hover:bg-slate-100 group-hover:text-primary">
                                            <i class="bi {{ $item['icon'] }} text-xl leading-none"></i>
                                        </span>
                                        <span class="text-[13px] font-black uppercase tracking-wider group-hover:text-primary">{{ $item['label'] }}</span>
                                    </span>
                                    <i class="bi bi-chevron-right text-sm text-slate-300 opacity-0 transition-all group-hover:translate-x-1 group-hover:opacity-100"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <section class="col-span-8">
                    <form method="POST" action="{{ route('admin.pengaturan.profil.update') }}" enctype="multipart/form-data" class="overflow-hidden rounded-[2.5rem] border border-slate-50 bg-white shadow-2xl shadow-slate-200/50">
                        @csrf
                        @method('PUT')

                        <div class="relative overflow-hidden bg-primary px-12 py-10 text-white">
                            <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
                            <div class="pointer-events-none absolute right-16 top-8 h-32 w-32 rounded-full bg-secondary/10 blur-2xl"></div>
                            <h3 class="relative mb-2 text-3xl font-black tracking-tight">Profil Institusi</h3>
                            <p class="relative max-w-lg text-sm font-medium leading-relaxed text-white/65">
                                Informasi dasar yang akan ditampilkan pada portal calon mahasiswa dan dokumen resmi pendaftaran.
                            </p>
                        </div>

                        <div class="space-y-12 p-12">
                            <div class="flex items-start gap-10 border-b border-slate-100 pb-12">
                                <label for="logo" class="group relative block cursor-pointer overflow-hidden rounded-3xl shadow-inner">
                                    <span class="flex h-40 w-40 items-center justify-center rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50 transition-all group-hover:border-primary/20 group-focus-within:border-primary/40">
                                        @if ($institution['logo'])
                                            <img src="{{ $institution['logo'] }}" alt="Logo Institusi" class="h-24 w-24 rounded-2xl object-contain transition-transform group-hover:scale-105">
                                        @else
                                            <span class="flex h-24 w-24 items-center justify-center rounded-2xl bg-sky-500 text-white transition-transform group-hover:scale-105">
                                                <i class="bi bi-bank2 text-5xl leading-none"></i>
                                            </span>
                                        @endif
                                        <span class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center bg-primary/40 text-white opacity-0 transition-opacity group-hover:opacity-100 group-focus-within:opacity-100">
                                            <i class="bi bi-camera-fill mb-2 text-3xl leading-none"></i>
                                            <span class="text-[10px] font-black uppercase tracking-widest">Ganti Logo</span>
                                        </span>
                                    </span>
                                    <span class="mt-3 block text-center text-[10px] font-black uppercase tracking-wider text-slate-700">Ganti Logo</span>
                                    <input id="logo" type="file" name="logo" accept=".png,.svg,.jpg,.jpeg" class="sr-only">
                                </label>

                                <div class="flex-1 pt-4">
                                    <h4 class="mb-2 text-xl font-black text-primary">Logo Institusi</h4>
                                    <p class="mb-6 max-w-md text-sm leading-relaxed text-slate-500">
                                        Gunakan file format PNG atau SVG dengan resolusi minimal 512x512px dan background transparan.
                                    </p>
                                    <button type="button" class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-slate-100 px-6 py-3 text-xs font-black text-primary transition-all hover:bg-slate-200 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                        <i class="bi bi-download text-base leading-none"></i>
                                        UNDUH TEMPLATE LOGO
                                    </button>
                                    @error('logo')
                                        <p class="mt-3 text-xs font-bold text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-8">
                                <div class="grid grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label for="nama_institusi" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nama Institusi</label>
                                        <input id="nama_institusi" name="nama_institusi" type="text" value="{{ old('nama_institusi', $institution['nama']) }}" class="w-full rounded-2xl border border-transparent bg-slate-50 px-6 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">
                                        @error('nama_institusi') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="kode_dikti" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Kode Institusi (DIKTI)</label>
                                        <input id="kode_dikti" name="kode_dikti" type="text" value="{{ old('kode_dikti', $institution['kode_dikti']) }}" class="w-full rounded-2xl border border-transparent bg-slate-50 px-6 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">
                                        @error('kode_dikti') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="alamat" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Alamat Pusat</label>
                                    <textarea id="alamat" name="alamat" rows="3" class="w-full resize-none rounded-2xl border border-transparent bg-slate-50 px-6 py-4 text-sm font-semibold leading-relaxed text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">{{ old('alamat', $institution['alamat']) }}</textarea>
                                    @error('alamat') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Email Official</label>
                                        <div class="relative">
                                            <i class="bi bi-envelope-fill absolute left-6 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                            <input id="email" name="email" type="email" value="{{ old('email', $institution['email']) }}" class="w-full rounded-2xl border border-transparent bg-slate-50 py-4 pl-14 pr-6 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">
                                        </div>
                                        @error('email') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="telepon" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nomor Telepon</label>
                                        <div class="relative">
                                            <i class="bi bi-telephone-fill absolute left-6 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                            <input id="telepon" name="telepon" type="text" value="{{ old('telepon', $institution['telepon']) }}" class="w-full rounded-2xl border border-transparent bg-slate-50 py-4 pl-14 pr-6 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">
                                        </div>
                                        @error('telepon') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="website" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Website Institusi</label>
                                    <div class="relative">
                                        <i class="bi bi-globe2 absolute left-6 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                        <input id="website" name="website" type="url" value="{{ old('website', $institution['website']) }}" class="w-full rounded-2xl border border-transparent bg-slate-50 py-4 pl-14 pr-6 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5">
                                    </div>
                                    @error('website') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-6 border-t border-slate-100 pt-8">
                                <button type="reset" class="cursor-pointer rounded-xl px-8 py-4 text-sm font-black text-slate-500 transition-all hover:bg-slate-50 hover:text-primary active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                    BATALKAN PERUBAHAN
                                </button>
                                <button type="submit" class="cursor-pointer rounded-xl bg-primary px-12 py-4 text-sm font-black text-white shadow-2xl shadow-primary/30 transition-all hover:bg-primary-dark active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                    SIMPAN PROFIL
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-10 flex items-start gap-6 rounded-2xl border-l-8 border-secondary bg-amber-50 p-8 shadow-sm shadow-amber-900/5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-secondary text-white shadow-lg shadow-secondary/20">
                            <i class="bi bi-info-circle-fill text-2xl leading-none"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 text-lg font-black text-amber-900">Verifikasi Sinkronisasi DIKTI</h5>
                            <p class="text-sm font-medium leading-relaxed text-amber-800/70">
                                Pembaruan nama dan kode institusi akan secara otomatis memicu sinkronisasi ulang dengan database PDDIKTI.
                                Pastikan data yang Anda masukkan sesuai dengan SK operasional terakhir.
                            </p>
                        </div>
                    </div>
                </section>
            </section>
    </main>
@endsection
