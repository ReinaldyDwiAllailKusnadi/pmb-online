@extends('layouts.admin')

@php
    $isEdit = $mode === 'edit';
    $title = $isEdit ? 'Edit Pendaftaran' : 'Tambah Pendaftaran';
    $description = $isEdit
        ? 'Perbarui data pendaftaran tanpa menghapus alur review yang sudah berjalan.'
        : 'Tambahkan data pendaftaran baru dari sisi admin.';
    $action = $isEdit
        ? route('admin.data-pendaftaran.update', $pendaftaran)
        : route('admin.data-pendaftaran.store');
@endphp

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'data-pendaftaran'])
    @include('admin.partials.topbar', ['showSearch' => false])

    <main class="admin-main-shell space-y-8 page-animate">
        <div class="flex items-end justify-between gap-6">
            <div>
                <a href="{{ $isEdit ? route('admin.data-pendaftaran.show', $pendaftaran) : route('admin.data-pendaftaran') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition-all hover:text-primary">
                    <i class="bi bi-arrow-left"></i>
                    {{ $isEdit ? 'Kembali ke Detail' : 'Kembali ke Data Pendaftaran' }}
                </a>
                <h2 class="text-4xl font-headline font-extrabold tracking-tight" style="color:#1E3A5F;">{{ $title }}</h2>
                <p class="mt-1 text-slate-500 font-medium">{{ $description }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ $action }}" class="rounded-3xl border border-slate-200/50 bg-white p-8 shadow-sm">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="nomor_pendaftaran" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nomor Pendaftaran</label>
                    <input
                        id="nomor_pendaftaran"
                        name="nomor_pendaftaran"
                        type="text"
                        value="{{ old('nomor_pendaftaran', $pendaftaran->nomor_pendaftaran) }}"
                        placeholder="Otomatis jika dikosongkan"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                    >
                    @error('nomor_pendaftaran') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="status" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="w-full cursor-pointer rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                    >
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $pendaftaran->status ?: 'draft') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="full_name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nama Mahasiswa</label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        value="{{ old('full_name', $pendaftaran->full_name) }}"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                    @error('full_name') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $pendaftaran->email) }}"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                    @error('email') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="program_studi_id" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Program Studi</label>
                    <select
                        id="program_studi_id"
                        name="program_studi_id"
                        class="w-full cursor-pointer rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                    >
                        <option value="">Pilih program studi</option>
                        @foreach ($programStudi as $program)
                            <option value="{{ $program->id }}" @selected((string) old('program_studi_id', $pendaftaran->program_studi_id) === (string) $program->id)>
                                {{ $program->displayName() }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_studi_id') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="gelombang_pendaftaran_id" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Gelombang</label>
                    <select
                        id="gelombang_pendaftaran_id"
                        name="gelombang_pendaftaran_id"
                        class="w-full cursor-pointer rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                    >
                        <option value="">Pilih gelombang</option>
                        @foreach ($gelombangPendaftaran as $gelombang)
                            <option value="{{ $gelombang->id }}" @selected((string) old('gelombang_pendaftaran_id', $pendaftaran->gelombang_pendaftaran_id) === (string) $gelombang->id)>
                                {{ $gelombang->nama }} - {{ $gelombang->tahun_akademik }}
                            </option>
                        @endforeach
                    </select>
                    @error('gelombang_pendaftaran_id') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="catatan_admin" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Catatan Admin</label>
                    <textarea
                        id="catatan_admin"
                        name="catatan_admin"
                        rows="4"
                        placeholder="Wajib jika status Perlu Revisi atau Ditolak"
                        class="w-full resize-none rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold leading-relaxed text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                    >{{ old('catatan_admin', $pendaftaran->catatan_admin) }}</textarea>
                    @error('catatan_admin') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-8 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ $isEdit ? route('admin.data-pendaftaran.show', $pendaftaran) : route('admin.data-pendaftaran') }}" class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-black text-slate-500 transition-all hover:bg-slate-50 hover:text-primary">
                    Batal
                </a>
                <button type="submit" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-8 py-3 text-sm font-black text-white shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5 hover:bg-primary-dark active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                    <i class="bi bi-save-fill"></i>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pendaftaran' }}
                </button>
            </div>
        </form>
    </main>
@endsection
