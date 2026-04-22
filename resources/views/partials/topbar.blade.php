@php
    $pageTitle = $pageTitle ?? ($pageLabel ?? null);
    if (isset($user) && is_array($user)) {
        $userName = $userName ?? ($user['name'] ?? null);
        $userAvatar = $userAvatar ?? ($user['avatar'] ?? null);
    }
    $userName = $userName ?? (auth()->user()->name ?? 'Mahasiswa');
    $userRole = strtoupper($userRole ?? 'Calon Mahasiswa');
    $photoPath = auth()->user()?->foto ?? null;
    $userAvatar = $userAvatar ?? ($photoPath ? asset('storage/' . $photoPath) : 'https://ui-avatars.com/api/?name=' . urlencode($userName));
    $notificationUser = auth()->user();
    $notificationsEnabled = $notificationUser && \Illuminate\Support\Facades\Schema::hasTable('notifications');
    $notifications = $notificationsEnabled
        ? \App\Models\Notification::query()
            ->where('user_id', $notificationUser->id)
            ->orderBy('is_read')
            ->latest('created_at')
            ->limit(5)
            ->get()
        : collect();
    $unreadNotifications = $notificationsEnabled
        ? \App\Models\Notification::query()
            ->where('user_id', $notificationUser->id)
            ->where('is_read', false)
            ->count()
        : 0;
    $notificationStyles = [
        'success' => 'bg-green-50 text-green-600',
        'warning' => 'bg-amber-50 text-amber-600',
        'error' => 'bg-red-50 text-red-600',
        'info' => 'bg-blue-50 text-blue-600',
    ];
@endphp

<header class="h-16 w-full sticky top-0 z-40 bg-white/80 backdrop-blur-md shadow-premium flex justify-between items-center px-8">
    <div class="flex items-center gap-4">
    <h1 class="text-xl font-bold text-primary font-plus-jakarta">{{ $pageTitle ?? 'Formulir Pendaftaran' }}</h1>
    </div>

    <div class="flex items-center gap-6">
        <div class="hidden md:flex relative">
            <input
                class="w-64 rounded-full border-none bg-surface-container py-2 pl-10 pr-4 text-sm outline-none transition-all focus:bg-white focus:ring-2 focus:ring-secondary"
                placeholder="Cari info pendaftaran..."
                type="text"
            />
            <i class="bi bi-search pointer-events-none absolute left-3 top-2.5 text-sm text-slate-400"></i>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative" data-dropdown>
                <button
                    type="button"
                    data-dropdown-trigger
                    aria-expanded="false"
                    class="relative cursor-pointer rounded-full p-2 text-slate-600 transition-colors hover:bg-slate-100 hover:text-primary active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60"
                >
                    <span class="sr-only">Buka notifikasi</span>
                    <i class="bi bi-bell text-lg"></i>
                    @if ($unreadNotifications > 0)
                        <span class="pointer-events-none absolute -right-1 -top-1 flex min-h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-black text-white">
                            {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                        </span>
                    @endif
                </button>
                <div
                    data-dropdown-menu
                    class="absolute right-0 top-12 z-50 hidden w-80 rounded-2xl border border-slate-100 bg-white p-4 text-sm shadow-xl shadow-slate-200/70"
                >
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Notifikasi</p>
                        @if ($unreadNotifications > 0 && Route::has('mahasiswa.notifikasi.read-all'))
                            <form method="POST" action="{{ route('mahasiswa.notifikasi.read-all') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-secondary transition-colors hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                                    Tandai dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="mt-3 space-y-2">
                        @forelse ($notifications as $notification)
                            @php
                                $style = $notificationStyles[$notification->type] ?? $notificationStyles['info'];
                            @endphp
                            <form method="POST" action="{{ route('mahasiswa.notifikasi.read', $notification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex w-full cursor-pointer gap-3 rounded-xl p-3 text-left transition-colors hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60 {{ $notification->is_read ? 'opacity-75' : 'bg-slate-50' }}">
                                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $style }}">
                                        <i class="bi {{ $notification->type === 'success' ? 'bi-check-circle-fill' : ($notification->type === 'warning' ? 'bi-exclamation-triangle-fill' : ($notification->type === 'error' ? 'bi-x-circle-fill' : 'bi-info-circle-fill')) }} text-sm"></i>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center gap-2">
                                            <span class="block truncate text-xs font-black text-primary">{{ $notification->title }}</span>
                                            @if (! $notification->is_read)
                                                <span class="h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                                            @endif
                                        </span>
                                        <span class="mt-1 block line-clamp-2 text-xs font-medium leading-relaxed text-slate-500">{{ $notification->message }}</span>
                                        <span class="mt-1 block text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $notification->created_at?->diffForHumans() }}</span>
                                    </span>
                                </button>
                            </form>
                        @empty
                            <div class="rounded-xl bg-slate-50 p-4 text-center text-xs font-semibold text-slate-500">
                                Belum ada notifikasi
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="relative border-l border-slate-200 pl-4" data-dropdown>
                <button
                    type="button"
                    data-dropdown-trigger
                    aria-expanded="false"
                    class="flex cursor-pointer items-center gap-3 rounded-xl px-2 py-1 transition-all hover:bg-slate-50 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60"
                >
                    <span class="text-right">
                        <span class="block text-sm font-bold text-primary">{{ $userName }}</span>
                        <span class="block text-[10px] text-slate-500 uppercase tracking-wider font-semibold">{{ $userRole }}</span>
                    </span>
                    <span class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden ring-2 ring-slate-100">
                        <img
                            class="w-full h-full object-cover"
                            src="{{ $userAvatar }}"
                            alt="Profile"
                            referrerpolicy="no-referrer"
                        />
                    </span>
                    <i class="bi bi-chevron-down text-xs text-slate-400"></i>
                </button>
                <div
                    data-dropdown-menu
                    class="absolute right-0 top-14 z-50 hidden w-56 overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 text-sm shadow-xl shadow-slate-200/70"
                >
                    <a href="{{ route('dashboard') }}" class="flex cursor-pointer items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold text-primary transition-colors hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                        <i class="bi bi-person-circle text-base"></i>
                        Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                        @csrf
                        <button type="submit" class="flex w-full cursor-pointer items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-bold text-red-600 transition-colors hover:bg-red-50 active:scale-[0.98] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/60">
                            <i class="bi bi-box-arrow-right text-base"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
