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

<aside class="fixed left-0 top-0 z-50 flex h-screen w-[260px] flex-col bg-primary-dark py-8 shadow-2xl">
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
               class="{{ $isActive ? 'bg-secondary text-white shadow-lg shadow-secondary/25' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center gap-3 rounded-xl px-4 py-3 text-[12px] font-bold uppercase tracking-wider transition-all duration-200">
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
                @if (($activePage ?? '') === 'pengaturan')
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-slate-400 transition-colors hover:text-white">Sign Out</button>
                    </form>
                @else
                    <p class="truncate text-xs text-slate-400">{{ $profileRole }}</p>
                @endif
            </div>
        </div>
    </div>
</aside>
