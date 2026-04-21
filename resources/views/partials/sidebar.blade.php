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
                class="group flex cursor-pointer items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70 focus-visible:ring-offset-2 focus-visible:ring-offset-primary {{ $link['active'] ? 'relative bg-secondary text-white font-bold shadow-lg after:absolute after:left-0 after:top-1/2 after:h-8 after:w-1 after:-translate-y-1/2 after:rounded-r-full after:bg-white after:pointer-events-none' : 'text-slate-300 hover:bg-white/5 hover:text-white active:scale-[0.98]' }}"
            >
                <i class="{{ $link['icon'] }} w-5 h-5 {{ $link['active'] ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-4 mt-auto space-y-3">
        <button type="button" class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition-all hover:bg-white/20 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70 focus-visible:ring-offset-2 focus-visible:ring-offset-primary">
            <i class="bi bi-headset w-4 h-4"></i>
            <span>Hubungi Bantuan</span>
        </button>
        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
            @csrf
            <button type="submit" class="flex w-full cursor-pointer items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition-all hover:bg-white/5 hover:text-white active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70 focus-visible:ring-offset-2 focus-visible:ring-offset-primary">
                <i class="bi bi-box-arrow-right w-5 h-5"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
