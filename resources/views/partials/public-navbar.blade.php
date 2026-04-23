<nav class="fixed top-0 z-50 w-full border-b border-outline-variant/10 bg-white/85 shadow-[0_2px_12px_rgba(30,58,95,0.08)] backdrop-blur-xl" data-public-navbar>
    <div class="mx-auto flex h-20 max-w-[1400px] items-center justify-between px-6">
        <a href="{{ route('home') }}" class="font-display text-2xl font-extrabold tracking-tighter text-primary">
            PMB Online
        </a>

        <div class="hidden items-center gap-8 font-display text-sm font-semibold tracking-tight md:flex">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-secondary pb-1 text-secondary' : 'text-primary hover:text-secondary' }}">
                Beranda
            </a>
            <a href="{{ route('program-studi.index') }}" class="{{ request()->routeIs('program-studi.*') ? 'border-b-2 border-secondary pb-1 text-secondary' : 'text-primary hover:text-secondary' }}">
                Program Studi
            </a>
            <a href="{{ route('informasi.index') }}" class="{{ request()->routeIs('informasi.index') ? 'border-b-2 border-secondary pb-1 text-secondary' : 'text-primary hover:text-secondary' }}">
                Informasi
            </a>
            <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'border-b-2 border-secondary pb-1 text-secondary' : 'text-primary hover:text-secondary' }}">
                Kontak
            </a>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            <a href="{{ route('login') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-primary hover:bg-surface-container-low">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="rounded-xl bg-primary px-6 py-3 text-sm font-bold text-white shadow-lg shadow-primary/20 hover:bg-[#1E3A5F] active:scale-95">
                Daftar
            </a>
        </div>

        <button
            type="button"
            class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-surface-container-low text-primary transition-colors hover:bg-surface-container-high md:hidden"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            data-public-navbar-toggle
        >
            <i class="bi bi-list text-2xl" data-menu-open-icon></i>
            <i class="bi bi-x-lg hidden text-xl" data-menu-close-icon></i>
        </button>
    </div>

    <div class="hidden border-t border-outline-variant/10 bg-white/95 px-6 py-4 shadow-lg md:hidden" data-public-navbar-menu>
        <div class="mx-auto flex max-w-[1400px] flex-col gap-2">
            <a href="{{ route('home') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('home') ? 'bg-secondary/10 text-secondary' : 'text-primary hover:bg-surface-container-low' }}">
                Beranda
            </a>
            <a href="{{ route('program-studi.index') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('program-studi.*') ? 'bg-secondary/10 text-secondary' : 'text-primary hover:bg-surface-container-low' }}">
                Program Studi
            </a>
            <a href="{{ route('informasi.index') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('informasi.index') ? 'bg-secondary/10 text-secondary' : 'text-primary hover:bg-surface-container-low' }}">
                Informasi
            </a>
            <a href="{{ route('kontak') }}" class="rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('kontak') ? 'bg-secondary/10 text-secondary' : 'text-primary hover:bg-surface-container-low' }}">
                Kontak
            </a>
            <div class="mt-3 grid grid-cols-2 gap-3 border-t border-outline-variant/10 pt-4">
                <a href="{{ route('login') }}" class="rounded-xl bg-gray-100 px-4 py-3 text-center text-sm font-bold text-gray-700 hover:bg-slate-200">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="rounded-xl bg-primary px-4 py-3 text-center text-sm font-bold text-white hover:bg-[#1E3A5F]">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>
