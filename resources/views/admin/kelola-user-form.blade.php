@extends('layouts.admin')

@php
    $isEdit = $mode === 'edit';
    $title = $isEdit ? 'Edit User' : 'Tambah User Baru';
    $description = $isEdit
        ? 'Perbarui profil, role, status, dan password user jika diperlukan.'
        : 'Tambahkan akun baru untuk admin atau calon mahasiswa.';
    $action = $isEdit
        ? route('admin.kelola-user.update', $user)
        : route('admin.kelola-user.store');
    $selectedRole = old('role', array_key_exists((string) $user->role, $roleOptions) ? $user->role : '');
@endphp

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'kelola-user'])
    @include('admin.partials.topbar', ['showSearch' => false])

    <main class="admin-main-shell space-y-8 page-animate">
        <div class="flex items-end justify-between gap-6">
            <div>
                <a href="{{ route('admin.kelola-user') }}" class="mb-4 inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition-all hover:text-primary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Kelola User
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
                    <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nama</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                    @error('name') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                    @error('email') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="role" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Role</label>
                    <select
                        id="role"
                        name="role"
                        class="w-full cursor-pointer rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                        @if ($isEdit && $user->role && ! array_key_exists((string) $user->role, $roleOptions))
                            <option value="" selected disabled>
                                Role lama: {{ strtoupper($user->role) }} - pilih role baru
                            </option>
                        @endif
                        @foreach ($roleOptions as $value => $label)
                            <option value="{{ $value }}" @selected($selectedRole === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="is_active" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status</label>
                    <select
                        id="is_active"
                        name="is_active"
                        class="w-full cursor-pointer rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        required
                    >
                        <option value="1" @selected((string) old('is_active', (int) $user->is_active) === '1')>Aktif</option>
                        <option value="0" @selected((string) old('is_active', (int) $user->is_active) === '0')>Nonaktif</option>
                    </select>
                    @error('is_active') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        {{ ! $isEdit ? 'required' : '' }}
                    >
                    <p class="text-xs font-semibold text-slate-400">
                        {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti password.' : 'Minimal 8 karakter.' }}
                    </p>
                    @error('password') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Konfirmasi Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        class="w-full rounded-2xl border border-transparent bg-slate-50 px-5 py-4 text-sm font-semibold text-slate-800 outline-none transition-all focus:border-slate-200 focus:bg-white focus:ring-4 focus:ring-primary/5"
                        {{ ! $isEdit ? 'required' : '' }}
                    >
                    @error('password_confirmation') <p class="text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.kelola-user') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-6 py-3 text-sm font-bold text-slate-600 transition-all hover:bg-slate-50 active:scale-[0.98]">
                    Batal
                </a>
                <button type="submit" class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-bold text-white shadow-lg transition-all hover:-translate-y-0.5 hover:opacity-90 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="background-color:#F0A500;">
                    <i class="bi bi-save-fill"></i>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan User' }}
                </button>
            </div>
        </form>
    </main>
@endsection

