@extends('layouts.admin')

@section('content')
    @include('admin.partials.sidebar', ['activePage' => 'kelola-user'])
    @include('admin.partials.topbar', ['placeholder' => 'Cari data user, email, atau role...'])

    <main class="admin-main-shell page-animate">
                <div class="flex justify-between items-end mb-8">
                    <div class="space-y-1">
                        <h2 class="text-4xl font-extrabold tracking-tight font-headline" style="color:#1E3A5F;">Kelola User</h2>
                        <p class="font-medium" style="color:#64748B;">Manajemen hak akses dan profil pengguna sistem.</p>
                    </div>
                    <button type="button" style="background-color:#F0A500;" class="flex cursor-pointer items-center gap-2 rounded-xl px-6 py-3 font-bold text-white shadow-lg transition-all hover:-translate-y-0.5 hover:opacity-90 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                        <i class="bi bi-person-plus-fill w-5 h-5"></i>
                        <span>Tambah User Baru</span>
                    </button>
                </div>

                @php
                    $activeTab = request('tab', 'semua');
                @endphp

                <div style="background-color:#FFFFFF;" class="rounded-2xl p-2 mb-6 flex flex-col md:flex-row items-center justify-between shadow-sm border border-slate-200/60">
                    <div class="flex gap-1 w-full md:w-auto">
                        <a
                            href="{{ route('admin.kelola-user', ['tab' => 'semua']) }}"
                            class="whitespace-nowrap rounded-xl px-6 py-2.5 text-sm font-semibold transition-all hover:bg-slate-100 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70"
                            style="{{ $activeTab === 'semua' ? 'background-color:#1a2744; color:white;' : 'color:#64748B;' }}"
                        >
                            Semua User
                        </a>
                        <a
                            href="{{ route('admin.kelola-user', ['tab' => 'admin']) }}"
                            class="whitespace-nowrap rounded-xl px-6 py-2.5 text-sm font-semibold transition-all hover:bg-slate-100 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70"
                            style="{{ $activeTab === 'admin' ? 'background-color:#1a2744; color:white;' : 'color:#64748B;' }}"
                        >
                            Admin
                        </a>
                        <a
                            href="{{ route('admin.kelola-user', ['tab' => 'calon-mahasiswa']) }}"
                            class="whitespace-nowrap rounded-xl px-6 py-2.5 text-sm font-semibold transition-all hover:bg-slate-100 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70"
                            style="{{ $activeTab === 'calon-mahasiswa' ? 'background-color:#1a2744; color:white;' : 'color:#64748B;' }}"
                        >
                            Calon Mahasiswa
                        </a>
                    </div>

                    <div class="flex items-center gap-3 pr-2 mt-4 md:mt-0">
                        <button type="button" class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 transition-all hover:bg-slate-100 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="color:#64748B;">
                            <i class="bi bi-funnel w-4 h-4"></i>
                            <span class="text-sm font-bold">Filters</span>
                        </button>
                        <button type="button" class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 transition-all hover:bg-slate-100 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" style="color:#64748B;">
                            <i class="bi bi-download w-4 h-4"></i>
                            <span class="text-sm font-bold">Export</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/60">
                    <table class="w-full text-left border-collapse">
                        <thead style="background-color: rgba(241,245,249,0.6);">
                            <tr class="border-b border-slate-200/60">
                                <th class="py-5 px-6 w-12">
                                    <input type="checkbox" class="cursor-pointer rounded border-slate-300 focus:ring-2 focus:ring-secondary/50" style="accent-color:#1E3A5F;" />
                                </th>
                                <th class="py-5 px-4 font-headline text-[10px] font-extrabold uppercase tracking-widest" style="color:#94a3b8;">Info Pengguna</th>
                                <th class="py-5 px-4 font-headline text-[10px] font-extrabold uppercase tracking-widest" style="color:#94a3b8;">Role</th>
                                <th class="py-5 px-4 font-headline text-[10px] font-extrabold uppercase tracking-widest" style="color:#94a3b8;">Status</th>
                                <th class="py-5 px-4 font-headline text-[10px] font-extrabold uppercase tracking-widest" style="color:#94a3b8;">Login Terakhir</th>
                                <th class="py-5 px-6 font-headline text-[10px] font-extrabold uppercase tracking-widest text-right" style="color:#94a3b8;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($users as $user)
                                @php
                                    $roleName = strtolower($user->role->nama_role ?? $user->role ?? 'calon mahasiswa');
                                    $roleClass = match($roleName) {
                                        'system admin', 'admin' => 'bg-blue-100 text-blue-800',
                                        'calon mahasiswa' => 'bg-amber-100 text-amber-800',
                                        'sekretariat' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                    $avatar = $user->foto
                                        ? asset('storage/' . $user->foto)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=e2e8f0&color=1E3A5F';
                                @endphp
                                <tr class="group hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6">
                                        <input type="checkbox" class="cursor-pointer rounded border-slate-300 focus:ring-2 focus:ring-secondary/50" style="accent-color:#1E3A5F;" />
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-4">
                                            <img
                                                src="{{ $avatar }}"
                                                alt="{{ $user->name }}"
                                                class="w-10 h-10 rounded-xl object-cover bg-slate-200"
                                                referrerpolicy="no-referrer"
                                            />
                                            <div>
                                                <h4 class="font-bold text-sm" style="color:#1E3A5F;">{{ $user->name }}</h4>
                                                <p class="text-xs" style="color:#64748B;">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full {{ $roleClass }}">
                                            {{ strtoupper($user->role->nama_role ?? $user->role ?? 'CALON MAHASISWA') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <form method="POST" action="{{ route('admin.kelola-user.toggle', $user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                @if($user->is_active)
                                                    <button type="submit" class="transition-all hover:brightness-110 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" aria-label="Nonaktifkan user" style="background-color:#1E3A5F; width:40px; height:20px; border-radius:9999px; position:relative; cursor:pointer; border:none;">
                                                        <span style="position:absolute; top:3px; right:3px; width:14px; height:14px; background:white; border-radius:9999px; box-shadow:0 1px 3px rgba(0,0,0,0.3);"></span>
                                                    </button>
                                                @else
                                                    <button type="submit" class="transition-all hover:brightness-105 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" aria-label="Aktifkan user" style="background-color:#CBD5E1; width:40px; height:20px; border-radius:9999px; position:relative; cursor:pointer; border:none;">
                                                        <span style="position:absolute; top:3px; left:3px; width:14px; height:14px; background:white; border-radius:9999px; box-shadow:0 1px 3px rgba(0,0,0,0.3);"></span>
                                                    </button>
                                                @endif
                                            </form>
                                            <span class="ml-3 text-xs font-bold" style="color: {{ $user->is_active ? '#1E3A5F' : '#64748B' }};">
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="text-xs font-medium" style="color:#1E3A5F;">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}</p>
                                        <p class="text-[10px]" style="color:#64748B;">IP: {{ $user->last_login_ip ?? '-' }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <button type="button" class="cursor-pointer rounded-lg p-2 text-slate-500 transition-all hover:bg-slate-100 hover:text-primary active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                                            <i class="bi bi-three-dots-vertical w-5 h-5"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @include('admin.partials.pagination-light', ['paginator' => $users])
                </div>

                <div class="mt-8 grid grid-cols-12 gap-6">
                    <div class="col-span-12 md:col-span-4 p-6 rounded-3xl relative overflow-hidden shadow-lg" style="background-color:#1a2744;">
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <p class="text-sm font-bold text-white/70 mb-2">Total User Aktif</p>
                                <div class="flex items-end gap-3">
                                    <p class="text-4xl font-extrabold text-white">
                                        {{ number_format($totalAktif ?? 0) }}
                                    </p>
                                    <span style="color:#F0A500" class="text-sm font-bold flex items-center gap-1 mb-1">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        {{ $trendPersen ?? '+0%' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <i class="bi bi-people-fill pointer-events-none absolute -right-6 -bottom-6 text-white/5 w-32 h-32"></i>
                    </div>

                    <div class="col-span-12 md:col-span-8 bg-white p-6 rounded-3xl flex flex-col sm:flex-row items-center justify-between shadow-sm border border-slate-200/60">
                        <div class="w-full sm:w-auto">
                            <h3 class="font-bold text-sm mb-4" style="color:#64748B;">Penyebaran Role User</h3>
                            <div class="flex flex-wrap gap-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color:#1E3A5F;"></div>
                                    <div>
                                        <p class="text-xs font-bold" style="color:#64748B;">Admin</p>
                                        <p class="text-lg font-extrabold" style="color:#1E3A5F;">{{ $roleStats['admin'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full" style="background-color:#F0A500;"></div>
                                    <div>
                                        <p class="text-xs font-bold" style="color:#64748B;">Pendaftar</p>
                                        <p class="text-lg font-extrabold" style="color:#1E3A5F;">{{ $roleStats['pendaftar'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                                    <div>
                                        <p class="text-xs font-bold" style="color:#64748B;">Sekretariat</p>
                                        <p class="text-lg font-extrabold" style="color:#1E3A5F;">{{ $roleStats['sekretariat'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-end w-full sm:w-auto mt-6 sm:mt-0 pt-6 sm:pt-0 sm:border-l border-slate-200/60 sm:pl-8">
                            <p class="text-xs font-bold mb-2" style="color:#64748B;">Storage Usage</p>
                            <div class="w-48 h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full" style="width: {{ $storagePercent }}%; background-color:#F0A500;"></div>
                            </div>
                            <p class="text-[10px] mt-2 font-bold uppercase tracking-widest" style="color:#64748B;">
                                {{ $storageUsed }} / {{ $storageTotal }}
                            </p>
                        </div>
                    </div>
                </div>
    </main>
@endsection
