@php
    $adminProfile = $adminProfile ?? ($admin ?? null);
    $profileName = $adminProfile['name'] ?? 'Admin Utama';
    $profileRole = $adminProfile['role'] ?? 'SUPERADMIN';
    $profileAvatar = $adminProfile['avatar'] ?? 'https://ui-avatars.com/api/?name='.urlencode($profileName).'&background=1E3A5F&color=fff&bold=true';

    $navItems = [
        ['icon' => 'bi-grid-1x2-fill', 'label' => 'Dashboard', 'key' => 'dashboard', 'route' => 'admin.dashboard'],
        ['icon' => 'bi-clipboard-check-fill', 'label' => 'Data Pendaftaran', 'key' => 'data-pendaftaran', 'route' => 'admin.data-pendaftaran'],
        ['icon' => 'bi-people-fill', 'label' => 'Kelola User', 'key' => 'kelola-user', 'route' => 'admin.kelola-user'],
        ['icon' => 'bi-bar-chart-line-fill', 'label' => 'Laporan', 'key' => 'laporan', 'route' => 'admin.laporan'],
        ['icon' => 'bi-gear-fill', 'label' => 'Pengaturan', 'key' => 'pengaturan', 'route' => 'admin.pengaturan'],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-primary-dark px-2 py-2 shadow-2xl lg:hidden">
    <div class="grid grid-cols-5 gap-1">
        @foreach ($navItems as $item)
            @php $isActive = ($activePage ?? '') === $item['key']; @endphp
            <a
                href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                class="flex flex-col items-center justify-center gap-1 rounded-xl px-2 py-2 text-[9px] font-bold uppercase tracking-tight transition-colors {{ $isActive ? 'bg-secondary text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="bi {{ $item['icon'] }} text-base"></i>
                <span class="truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>

<aside class="admin-sidebar fixed left-0 top-0 z-50 hidden h-screen w-[260px] flex-col bg-primary-dark py-8 shadow-2xl lg:flex">
    <div class="mb-12 flex items-center gap-4 px-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-lg">
            <i class="bi bi-bank2 text-[21px] text-primary"></i>
        </div>
        <div>
            <h1 class="text-xl font-extrabold leading-tight tracking-tight text-white">PMB Gateway</h1>
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Admin Portal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-2 px-4">
        @foreach ($navItems as $item)
            @php $isActive = ($activePage ?? '') === $item['key']; @endphp
            <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
               class="{{ $isActive ? 'bg-secondary text-white shadow-lg shadow-secondary/25' : 'text-slate-300 hover:bg-white/5 hover:text-white active:scale-[0.98]' }} flex cursor-pointer items-center gap-3 rounded-xl px-4 py-3 text-[12px] font-bold uppercase tracking-wider transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70 focus-visible:ring-offset-2 focus-visible:ring-offset-primary-dark">
                <i class="bi {{ $item['icon'] }} w-5 text-center text-xl leading-none"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto border-t border-white/10 px-6 pt-6">
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="{{ $profileAvatar }}" alt="Admin Avatar" class="h-11 w-11 rounded-full border-2 border-secondary object-cover" referrerpolicy="no-referrer">
                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-primary-dark bg-green-500"></span>
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-bold text-white">{{ ($activePage ?? '') === 'pengaturan' ? 'Admin Utama' : $profileName }}</p>
                <p class="truncate text-xs text-slate-400">{{ ($activePage ?? '') === 'pengaturan' ? 'SUPERADMIN' : $profileRole }}</p>
                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')" class="mt-1">
                    @csrf
                    <button type="submit" class="inline-flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-slate-400 transition-colors hover:text-white active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70">
                        <i class="bi bi-box-arrow-right text-sm"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
