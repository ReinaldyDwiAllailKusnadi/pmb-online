@php
    $showSearch = $showSearch ?? true;
    $userLabel = $userLabel ?? 'Administrator';
@endphp

<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/50 sticky top-0 flex items-center justify-between px-8 z-40">
    <div class="flex-1 max-w-lg">
        @if ($showSearch)
            <div class="relative group">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-accent transition-colors"></i>
                <input
                    type="text"
                    placeholder="Cari nomor pendaftaran atau nama..."
                    class="w-full h-11 pl-11 pr-4 bg-slate-100 rounded-xl border-none focus:ring-2 focus:ring-accent/20 placeholder:text-slate-400 text-sm font-medium transition-all"
                />
            </div>
        @endif
    </div>

    <div class="flex items-center gap-6">
        <div class="flex items-center gap-2">
            <button class="relative p-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                <i class="bi bi-bell-fill"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white shadow-sm"></span>
            </button>
            <button class="p-2.5 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                <i class="bi bi-question-circle"></i>
            </button>
        </div>
        <div class="w-px h-8 bg-slate-200"></div>
        <div class="flex items-center gap-3">
            <img
                src="https://picsum.photos/seed/admin/100/100"
                alt="Profile"
                class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-100"
                referrerpolicy="no-referrer"
            />
            <span class="font-headline font-bold text-primary text-sm">{{ $userLabel }}</span>
        </div>
    </div>
</header>
