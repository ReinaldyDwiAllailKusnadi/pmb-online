@php
    $showSearch = $showSearch ?? true;
    $placeholder = $placeholder ?? 'Cari data...';
    $academicYear = $academicYear ?? null;
    $adminName = $adminName ?? 'Direktorat TIK';
    $adminRole = $adminRole ?? 'SUPERADMIN';
    $topbarHeight = $topbarHeight ?? 80;
@endphp

<header class="admin-topbar fixed right-0 top-0 z-40 flex h-20 w-[calc(100%-260px)] items-center justify-between border-b border-slate-100 bg-white/80 px-10 backdrop-blur-md">
    <div class="flex max-w-xl flex-1 items-center">
        @if ($showSearch)
            <div class="group relative w-full">
                <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xl leading-none text-slate-400 transition-colors group-focus-within:text-primary"></i>
                <input type="text"
                       placeholder="{{ $placeholder }}"
                       class="w-full rounded-xl border-none bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-700 outline-none transition-all placeholder:text-slate-400 focus:bg-slate-100 focus:ring-2 focus:ring-primary/5">
            </div>
        @endif
    </div>

    <div class="ml-6 flex items-center gap-4">
        <button type="button" class="group relative cursor-pointer rounded-xl p-3 text-primary transition-all hover:bg-slate-50 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" aria-label="Notifikasi">
            <i class="bi bi-bell-fill text-xl leading-none"></i>
            <span class="pointer-events-none absolute right-3 top-3 h-2.5 w-2.5 animate-pulse rounded-full border-2 border-white bg-red-500 ring-2 ring-red-500/20"></span>
        </button>
        <button type="button" class="cursor-pointer rounded-xl p-3 text-primary transition-all hover:bg-slate-50 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" aria-label="Bantuan">
            <i class="bi bi-question-circle-fill text-xl leading-none"></i>
        </button>
        <div class="mx-4 h-10 w-px bg-slate-200"></div>
        @if ($academicYear)
            <div class="hidden items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-bold text-primary lg:flex">
                <i class="bi bi-calendar-event-fill text-slate-500"></i>
                <span>{{ $academicYear }}</span>
            </div>
        @endif
        <div class="text-right">
            <p class="text-sm font-black tracking-tight text-primary">{{ $adminName }}</p>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-on-surface-variant">{{ strtoupper($adminRole) }}</p>
        </div>
    </div>
</header>
