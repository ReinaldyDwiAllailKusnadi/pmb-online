@props(['current' => 'dashboard'])

@php
    $navItems = [
        ['id' => 'dashboard', 'label' => 'Beranda', 'icon' => 'layout-dashboard', 'route' => 'dashboard'],
        ['id' => 'registration', 'label' => 'Formulir Pendaftaran', 'icon' => 'file-text', 'route' => 'form.step1'],
        ['id' => 'status', 'label' => 'Status Pendaftaran', 'icon' => 'clipboard-check', 'route' => 'status'],
        ['id' => 'pdf', 'label' => 'Unduh Bukti PDF', 'icon' => 'file-down', 'route' => 'pdf'],
    ];
@endphp

<aside class="fixed left-0 top-0 h-full w-65 bg-primary-container flex flex-col py-6 z-50 text-slate-300">
    <div class="px-6 mb-10 flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center overflow-hidden">
            <x-lucide-icon name="graduation-cap" class="text-primary w-7 h-7" />
        </div>
        <div>
            <h1 class="text-white text-lg font-extrabold leading-none">Akademi PMB</h1>
            <p class="text-slate-400 text-[10px] font-medium tracking-wider uppercase mt-1 text-nowrap">Student Portal</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 px-4">
        @foreach ($navItems as $item)
            @php
                $active = $current === $item['id'] || ($item['id'] === 'registration' && str_starts_with($current, 'form-'));
            @endphp
            <a
                href="{{ route($item['route']) }}"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all font-medium text-sm {{ $active ? 'bg-secondary text-white border-l-4 border-white' : 'hover:bg-white/10 hover:text-white' }}"
            >
                <x-lucide-icon name="{{ $item['icon'] }}" class="w-5 h-5" />
                <span class="text-sm tracking-wide">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="px-4 mt-auto">
        <button class="w-full py-3 px-4 rounded-lg bg-white/10 text-white hover:bg-white/20 transition-all flex items-center justify-center gap-2 text-sm font-medium mb-4">
            <x-lucide-icon name="help-circle" class="w-4 h-4" />
            <span>Hubungi Bantuan</span>
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500/20 hover:text-red-400 transition-all text-sm font-medium"
            >
                <x-lucide-icon name="log-out" class="w-5 h-5" />
                <span class="text-sm">Keluar</span>
            </button>
        </form>
    </div>
</aside>