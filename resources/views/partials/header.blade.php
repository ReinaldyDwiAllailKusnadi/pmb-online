@props(['title' => '', 'userName' => 'Budi Santoso', 'regNo' => '202409821'])

<header class="h-16 w-full sticky top-0 z-40 bg-white/80 backdrop-blur-md flex justify-between items-center px-8 shadow-[0_2px_12px_rgba(30,58,95,0.08)]">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-primary">{{ $title }}</h2>
    </div>
    <div class="flex items-center gap-6">
        <div class="hidden md:flex relative">
            <input
                type="text"
                placeholder="Cari info pendaftaran..."
                class="pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-secondary"
            />
            <x-lucide-icon name="search" class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" />
        </div>
        <div class="relative group">
            <x-lucide-icon name="bell" class="w-6 h-6 text-slate-600 cursor-pointer hover:text-secondary transition-colors" />
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </div>
        <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-primary">{{ $userName }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-tighter">Reg No: {{ $regNo }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-surface-container overflow-hidden ring-2 ring-slate-100">
                <img
                    src="https://picsum.photos/seed/student-jerry/100/100"
                    alt="User"
                    class="w-full h-full object-cover"
                    referrerpolicy="no-referrer"
                />
            </div>
        </div>
    </div>
</header>