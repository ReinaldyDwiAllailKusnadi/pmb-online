@php
    $sidebarLinks = $sidebarLinks ?? [
        [
            'icon' => 'bi bi-grid-1x2',
            'label' => 'Beranda',
            'active' => request()->routeIs('dashboard'),
            'href' => route('dashboard'),
        ],
        [
            'icon' => 'bi bi-file-text',
            'label' => 'Formulir Pendaftaran',
            'active' => request()->routeIs('form.*'),
            'href' => route('form.step1'),
        ],
        [
            'icon' => 'bi bi-clipboard-check',
            'label' => 'Status Pendaftaran',
            'active' => request()->routeIs('status') || request()->routeIs('status.pendaftaran'),
            'href' => route('status.pendaftaran'),
        ],
        [
            'icon' => 'bi bi-file-earmark-arrow-down',
            'label' => 'Unduh Bukti PDF',
            'active' => request()->routeIs('pdf'),
            'href' => route('pdf'),
        ],
    ];
@endphp

<aside class="fixed left-0 top-0 h-full w-[260px] bg-primary shadow-xl flex flex-col py-8 z-50 overflow-y-auto">
    <div class="px-6 mb-12 flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
            <img
                class="w-8 h-8"
                src="{{ asset('images/logo.png') }}"
                alt="Logo"
            />
        </div>
        <div>
            <h1 class="text-white text-lg font-extrabold leading-none tracking-tight">Akademi PMB</h1>
            <p class="text-slate-400 text-[10px] font-bold tracking-wider uppercase mt-1">Student Portal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1.5 px-4">
        @foreach ($sidebarLinks as $link)
            <a
                href="{{ $link['href'] ?? '#' }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 font-medium text-sm group {{ $link['active'] ? 'bg-secondary text-white shadow-lg shadow-secondary/20 border-l-4 border-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
            >
                <i class="{{ $link['icon'] }} w-5 h-5 {{ $link['active'] ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-4 mt-auto space-y-3">
        <button class="w-full py-3 px-4 rounded-xl bg-white/5 text-white hover:bg-white/15 transition-all flex items-center justify-center gap-2 text-sm font-semibold border border-white/10 backdrop-blur-sm">
            <i class="bi bi-question-circle w-4 h-4"></i>
            <span>Hubungi Bantuan</span>
        </button>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all text-sm font-medium">
            <i class="bi bi-box-arrow-right w-5 h-5"></i>
            <span>Keluar</span>
        </a>
    </div>
</aside>