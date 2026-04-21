@php
    $legacyCurrent = $current ?? null;
    $activePage = $activePage ?? match ($legacyCurrent) {
        'dashboard' => 'beranda',
        'registration' => 'formulir',
        'status' => 'status',
        'pdf' => 'unduh-bukti',
        default => null,
    };
    $navItems = [
        [
            'id' => 'beranda',
            'icon' => 'bi bi-grid-1x2',
            'label' => 'Beranda',
            'href' => route('dashboard'),
            'active' => $activePage ? $activePage === 'beranda' : request()->routeIs('dashboard'),
        ],
        [
            'id' => 'formulir',
            'icon' => 'bi bi-file-text',
            'label' => 'Formulir Pendaftaran',
            'href' => route('form.step1'),
            'active' => $activePage ? $activePage === 'formulir' : request()->routeIs('form.*'),
        ],
        [
            'id' => 'status',
            'icon' => 'bi bi-clipboard-check',
            'label' => 'Status Pendaftaran',
            'href' => route('status.pendaftaran'),
            'active' => $activePage ? $activePage === 'status' : (request()->routeIs('status') || request()->routeIs('status.pendaftaran')),
        ],
        [
            'id' => 'unduh-bukti',
            'icon' => 'bi bi-file-earmark-arrow-down',
            'label' => 'Unduh Bukti PDF',
            'href' => route('mahasiswa.unduh-bukti'),
            'active' => $activePage ? $activePage === 'unduh-bukti' : request()->routeIs('mahasiswa.unduh-bukti'),
        ],
    ];
@endphp

<aside class="fixed left-0 top-0 h-full w-65 bg-primary shadow-xl flex flex-col py-8 z-50 overflow-y-auto">
    <div class="px-6 mb-12 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center text-white shadow-lg shadow-secondary/20">
            <i class="bi bi-mortarboard-fill text-xl"></i>
        </div>
        <div>
            <h1 class="text-white text-lg font-extrabold leading-none tracking-tight">Akademi PMB</h1>
            <p class="text-slate-400 text-[10px] font-bold tracking-wider uppercase mt-1">Student Portal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1.5 px-4">
        @foreach ($navItems as $link)
            <a
                href="{{ $link['href'] ?? '#' }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 font-medium text-sm group {{ $link['active'] ? 'bg-secondary text-white font-bold shadow-lg relative after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:h-8 after:w-1 after:bg-white after:rounded-r-full' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >
                <i class="{{ $link['icon'] }} w-5 h-5 {{ $link['active'] ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-4 mt-auto space-y-3">
        <button class="w-full py-3 px-4 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-all flex items-center justify-center gap-2 text-sm font-semibold">
            <i class="bi bi-headset w-4 h-4"></i>
            <span>Hubungi Bantuan</span>
        </button>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-white/5 hover:text-white transition-all text-sm font-medium">
            <i class="bi bi-box-arrow-right w-5 h-5"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>