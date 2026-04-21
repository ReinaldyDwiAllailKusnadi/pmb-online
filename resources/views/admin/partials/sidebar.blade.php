<aside style="background-color:#1a2744 !important; width:260px; min-height:100vh;"
             class="fixed left-0 top-0 flex flex-col py-6 z-50 shadow-2xl overflow-y-auto">

    <div class="px-6 mb-10 flex items-center gap-3">
        <div style="background-color:#c98a00; width:40px; height:40px; border-radius:8px;"
            class="flex items-center justify-center shrink-0">
            <i class="bi bi-building text-white" style="font-size:18px;"></i>
        </div>
        <div>
            <h1 style="color:white; font-size:18px; font-weight:800; letter-spacing:-0.02em; line-height:1.2;">
                PMB Gateway
            </h1>
            <p style="color:#94a3b8; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; margin-top:2px;">
                Admin Portal
            </p>
        </div>
    </div>

    <nav class="flex-1 flex flex-col gap-1 px-3">
        @php
            $navItems = [
                ['icon'=>'bi-grid-1x2-fill',      'label'=>'Dashboard',        'key'=>'dashboard'],
                ['icon'=>'bi-person-check-fill',  'label'=>'Data Pendaftaran', 'key'=>'data-pendaftaran'],
                ['icon'=>'bi-people-fill',        'label'=>'Kelola User',      'key'=>'kelola-user'],
                ['icon'=>'bi-bar-chart-line-fill','label'=>'Laporan',          'key'=>'laporan'],
                ['icon'=>'bi-gear-fill',          'label'=>'Pengaturan',       'key'=>'pengaturan'],
            ];
        @endphp

        @foreach($navItems as $item)
            @php $isActive = ($activePage ?? '') === $item['key']; @endphp
            <a href="{{ route('admin.'.$item['key']) }}"
                 style="{{ $isActive
                     ? 'background-color:#F0A500; color:white; font-weight:700; box-shadow:0 4px 12px rgba(240,165,0,0.25);'
                     : 'color:#94a3b8;' }}"
                 class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm tracking-wide transition-all duration-200 hover:text-white"
                 onmouseover="{{ !$isActive ? 'this.style.backgroundColor=\'rgba(255,255,255,0.07)\'' : '' }}"
                 onmouseout="{{ !$isActive ? 'this.style.backgroundColor=\'transparent\'' : '' }}">
                <i class="bi {{ $item['icon'] }}" style="font-size:18px; width:20px; text-align:center;"></i>
                <span>{{ $item['label'] }}</span>
                @if($isActive)
                    <span style="margin-left:auto; width:6px; height:6px; background:white; border-radius:50%; display:block;"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="px-6 pt-6 mt-auto" style="border-top:1px solid rgba(255,255,255,0.1);">
        <div class="flex items-center gap-3">
            <img src="{{ Auth::user()->foto
                        ? asset('storage/'.Auth::user()->foto)
                        : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=1E3A5F&color=fff&bold=true' }}"
                     alt="Admin"
                       style="width:40px; height:40px; border-radius:50%; border:2px solid #F0A500; object-fit:cover;">
            <div class="overflow-hidden">
                <p style="color:white; font-size:14px; font-weight:700;" class="truncate">{{ Auth::user()->name }}</p>
                <p style="color:#94a3b8; font-size:11px;" class="truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
