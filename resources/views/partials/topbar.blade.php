@php
    $pageTitle = $pageTitle ?? ($pageLabel ?? null);
    $userName = $userName ?? (auth()->user()->name ?? 'Mahasiswa');
    $userRole = strtoupper($userRole ?? 'Calon Mahasiswa');
    $photoPath = auth()->user()?->foto ?? null;
    $userAvatar = $userAvatar ?? ($photoPath ? asset('storage/' . $photoPath) : 'https://ui-avatars.com/api/?name=' . urlencode($userName));
@endphp

<header class="h-16 w-full sticky top-0 z-40 bg-white/80 backdrop-blur-md shadow-premium flex justify-between items-center px-8">
    <div class="flex items-center gap-4">
    <h1 class="text-xl font-bold text-primary font-plus-jakarta">{{ $pageTitle ?? 'Formulir Pendaftaran' }}</h1>
    </div>

    <div class="flex items-center gap-6">
        <div class="hidden md:flex relative">
            <input
                class="pl-10 pr-4 py-2 bg-surface-container border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-secondary transition-all outline-none"
                placeholder="Cari info pendaftaran..."
                type="text"
            />
            <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-sm"></i>
        </div>
        <div class="flex items-center gap-4">
            <button class="p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors relative">
                <i class="bi bi-bell text-lg"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                <div class="text-right">
                    <p class="text-sm font-bold text-primary">{{ $userName }}</p>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">{{ $userRole }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden ring-2 ring-slate-100">
                    <img
                        class="w-full h-full object-cover"
                        src="{{ $userAvatar }}"
                        alt="Profile"
                        referrerpolicy="no-referrer"
                    />
                </div>
            </div>
        </div>
    </div>
</header>
