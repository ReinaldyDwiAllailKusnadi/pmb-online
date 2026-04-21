@php
    $activePage = $activePage ?? null;
    $navItems = [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi bi-grid-1x2-fill', 'href' => route('admin.dashboard')],
        ['id' => 'data-pendaftaran', 'label' => 'Data Pendaftaran', 'icon' => 'bi bi-person-check-fill', 'href' => route('admin.data-pendaftaran')],
        ['id' => 'users', 'label' => 'Kelola User', 'icon' => 'bi bi-people-fill', 'href' => '#'],
        ['id' => 'laporan', 'label' => 'Laporan', 'icon' => 'bi bi-bar-chart-line-fill', 'href' => '#'],
        ['id' => 'pengaturan', 'label' => 'Pengaturan', 'icon' => 'bi bi-gear-fill', 'href' => '#'],
    ];
    $userName = $userName ?? (auth()->user()->name ?? 'John Doe');
    $userRole = $userRole ?? 'Administrator';
@endphp

<aside class="fixed inset-y-0 left-0 w-64 bg-primary flex flex-col z-50">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center p-1.5 shadow-lg shadow-black/10">
            <i class="bi bi-patch-check-fill text-primary w-full h-full"></i>
        </div>
        <div>
            <h1 class="text-white font-headline font-bold text-lg leading-tight tracking-tight">PMB Gateway</h1>
            <p class="text-white/50 text-[10px] font-bold uppercase tracking-wider">Admin Portal</p>
        </div>
    </div>

    <nav class="flex-1 px-3 mt-4 space-y-1">
        @foreach ($navItems as $item)
            <a
                href="{{ $item['href'] }}"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ $activePage === $item['id'] ? 'bg-accent text-white shadow-xl shadow-accent/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
            >
                <i class="{{ $item['icon'] }} transition-transform duration-300 {{ $activePage === $item['id'] ? '' : 'group-hover:scale-110' }}"></i>
                <span class="font-headline font-semibold text-sm">{{ $item['label'] }}</span>
                @if ($activePage === $item['id'])
                    <div class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="p-4 mt-auto">
        <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center font-headline font-bold text-white shadow-inner">
                    {{ strtoupper(substr($userName, 0, 1)) }}{{ strtoupper(substr(strrchr($userName, ' ') ?: $userName, 1, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-white font-semibold text-sm truncate">{{ $userName }}</p>
                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest truncate">{{ $userRole }}</p>
                </div>
                <button class="text-white/40 hover:text-white transition-colors">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</aside>
