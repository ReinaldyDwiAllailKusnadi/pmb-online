<header class="sticky top-0 h-16 w-full bg-white/80 backdrop-blur-xl border-b border-slate-200/60 flex items-center justify-between px-8 z-40">
    <h2 class="text-xl font-bold text-primary tracking-tight">Status Pendaftaran</h2>
    <div class="flex items-center gap-6">
        <div class="relative cursor-pointer group">
            <i class="bi bi-bell w-6 h-6 text-slate-500 group-hover:text-secondary transition-colors"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-secondary border-2 border-white rounded-full"></span>
        </div>
        <div class="flex items-center gap-4 pl-6 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-primary leading-tight">{{ $user['name'] }}</p>
                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Reg No: {{ $user['regNo'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-full border-2 border-slate-100 overflow-hidden shadow-sm">
                <img
                    class="w-full h-full object-cover"
                    src="{{ $user['avatar'] }}"
                    alt="Avatar"
                />
            </div>
        </div>
    </div>
</header>
