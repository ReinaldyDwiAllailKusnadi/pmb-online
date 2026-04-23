@php
    $showSearch = $showSearch ?? true;
    $placeholder = $placeholder ?? 'Cari data...';
    $searchName = $searchName ?? 'q';
    $searchAction = $searchAction ?? url()->current();
    $searchValue = old($searchName, request($searchName));
    $academicYear = $academicYear ?? null;
    $adminName = $adminName ?? 'Direktorat TIK';
    $adminRole = $adminRole ?? 'SUPERADMIN';
    $topbarHeight = $topbarHeight ?? 80;
    $notificationUser = auth()->user();
    $notificationsEnabled = $notificationUser
        && \Illuminate\Support\Facades\Schema::hasTable('notifications')
        && \Illuminate\Support\Facades\Route::has('admin.notifications.read')
        && \Illuminate\Support\Facades\Route::has('admin.notifications.read-all');
    $adminNotifications = $notificationsEnabled
        ? \App\Models\Notification::query()
            ->where('user_id', $notificationUser->id)
            ->orderBy('is_read')
            ->latest('created_at')
            ->limit(5)
            ->get()
        : collect();
    $unreadNotificationsCount = $notificationsEnabled
        ? \App\Models\Notification::query()
            ->where('user_id', $notificationUser->id)
            ->where('is_read', false)
            ->count()
        : 0;
@endphp

<header class="admin-topbar fixed right-0 top-0 z-40 flex h-20 w-[calc(100%-260px)] items-center justify-between border-b border-slate-100 bg-white/80 px-10 backdrop-blur-md">
    <div class="flex max-w-xl flex-1 items-center">
        @if ($showSearch)
            <form method="GET" action="{{ $searchAction }}" class="group relative w-full">
                @foreach (request()->except([$searchName, 'page']) as $key => $value)
                    @if (is_array($value))
                        @foreach ($value as $item)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-xl leading-none text-slate-400 transition-colors group-focus-within:text-primary"></i>
                <input type="text"
                       name="{{ $searchName }}"
                       value="{{ $searchValue }}"
                       placeholder="{{ $placeholder }}"
                       class="w-full rounded-xl border-none bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-700 outline-none transition-all placeholder:text-slate-400 focus:bg-slate-100 focus:ring-2 focus:ring-primary/5">
            </form>
        @endif
    </div>

    <div class="ml-6 flex items-center gap-4">
        <div class="relative" data-admin-notifications>
            <button type="button" class="group relative cursor-pointer rounded-xl p-3 text-primary transition-all hover:bg-slate-50 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-secondary/70" aria-label="Notifikasi" aria-expanded="false" data-admin-notification-toggle>
                <i class="bi bi-bell-fill text-xl leading-none"></i>
                @if ($unreadNotificationsCount > 0)
                    <span class="absolute -right-1 -top-1 flex min-h-5 min-w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 px-1 text-[10px] font-black leading-none text-white ring-2 ring-red-500/20">
                        {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                    </span>
                @endif
            </button>

            <div class="absolute right-0 top-full z-50 mt-3 hidden w-96 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10" data-admin-notification-menu>
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <p class="text-sm font-black text-primary">Notifikasi</p>
                        <p class="text-[11px] font-semibold text-slate-400">{{ $unreadNotificationsCount }} belum dibaca</p>
                    </div>
                    @if ($unreadNotificationsCount > 0)
                        <form method="POST" action="{{ route('admin.notifications.read-all') }}" data-allow-resubmit="true">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg px-3 py-2 text-[11px] font-black text-secondary transition-all hover:bg-amber-50">
                                Tandai semua
                            </button>
                        </form>
                    @endif
                </div>

                <div class="max-h-96 overflow-y-auto">
                    @forelse ($adminNotifications as $notification)
                        @php
                            $typeClass = match($notification->type) {
                                'success' => 'bg-emerald-50 text-emerald-600',
                                'warning' => 'bg-amber-50 text-amber-600',
                                'error' => 'bg-red-50 text-red-600',
                                default => 'bg-blue-50 text-blue-600',
                            };
                        @endphp
                        <form method="POST" action="{{ route('admin.notifications.read', $notification) }}" data-allow-resubmit="true">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex w-full gap-3 px-5 py-4 text-left transition-all hover:bg-slate-50 {{ $notification->is_read ? 'opacity-70' : 'bg-slate-50/40' }}">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $typeClass }}">
                                    <i class="bi bi-info-circle-fill"></i>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="flex items-start justify-between gap-3">
                                        <span class="text-sm font-black text-primary">{{ $notification->title }}</span>
                                        @unless ($notification->is_read)
                                            <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                                        @endunless
                                    </span>
                                    <span class="mt-1 block text-xs font-medium leading-relaxed text-slate-500">{{ $notification->message }}</span>
                                    <span class="mt-2 block text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        {{ $notification->created_at?->diffForHumans() ?? '-' }}
                                    </span>
                                </span>
                            </button>
                        </form>
                    @empty
                        <div class="px-5 py-8 text-center text-sm font-bold text-slate-400">
                            Belum ada notifikasi
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
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

@once
    @push('scripts')
        <script>
            document.addEventListener('click', function (event) {
                const toggle = event.target.closest('[data-admin-notification-toggle]');
                const currentRoot = event.target.closest('[data-admin-notifications]');

                document.querySelectorAll('[data-admin-notifications]').forEach(function (root) {
                    if (root !== currentRoot || toggle) {
                        const menu = root.querySelector('[data-admin-notification-menu]');
                        const button = root.querySelector('[data-admin-notification-toggle]');

                        if (menu && button && (root !== currentRoot || !toggle)) {
                            menu.classList.add('hidden');
                            button.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                if (!toggle || !currentRoot) {
                    return;
                }

                const menu = currentRoot.querySelector('[data-admin-notification-menu]');
                const isOpen = !menu.classList.contains('hidden');

                menu.classList.toggle('hidden', isOpen);
                toggle.setAttribute('aria-expanded', String(!isOpen));
            });

            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') {
                    return;
                }

                document.querySelectorAll('[data-admin-notification-menu]').forEach(function (menu) {
                    menu.classList.add('hidden');
                });

                document.querySelectorAll('[data-admin-notification-toggle]').forEach(function (button) {
                    button.setAttribute('aria-expanded', 'false');
                });
            });
        </script>
    @endpush
@endonce
