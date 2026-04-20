@php
    $pageLabel = $pageLabel ?? null;
    $userName = $userName ?? (auth()->user()->name ?? 'Mahasiswa');
    $userRole = $userRole ?? 'Calon Mahasiswa';
    $userAvatar = $userAvatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($userName);
@endphp

<header class="sticky top-0 z-40 flex h-16 items-center border-b border-slate-200 bg-white/80 px-8 backdrop-blur-md">
    <div class="flex items-center gap-2">
        <span class="text-sm font-bold tracking-widest text-secondary uppercase">{{ $pageLabel ?? 'E-SERTIFIKAT & BUKTI' }}</span>
    </div>

    <div class="flex-1 flex items-center justify-center">
        <div class="relative group">
            <input
                type="text"
                placeholder="Cari informasi..."
                class="w-72 rounded-full border-none bg-slate-100 px-4 py-1.5 text-sm transition-all focus:ring-2 focus:ring-primary/20"
            />
            <i class="bi bi-search absolute right-3 top-2 h-4 w-4 text-slate-400"></i>
        </div>
    </div>

    <div class="flex items-center gap-4 border-l border-slate-200 pl-6">
        <button class="text-slate-600 transition-colors hover:text-primary relative">
            <i class="bi bi-bell"></i>
            <span class="absolute -top-1 -right-1 h-2 w-2 rounded-full bg-red-500 border-2 border-white"></span>
        </button>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs font-bold leading-none text-primary">{{ $userName }}</p>
                <p class="text-[10px] font-medium text-slate-500">{{ $userRole }}</p>
            </div>
            <img
                src="{{ $userAvatar }}"
                alt="Avatar"
                class="h-9 w-9 rounded-full object-cover ring-2 ring-slate-100"
            />
        </div>
    </div>
</header>
