@php
        $showSearch = $showSearch ?? true;
        $placeholder = $placeholder ?? 'Cari data user, email, atau role...';
        $showLangDropdown = $showLangDropdown ?? true;
@endphp

<header style="position:fixed; top:0; left:260px; right:0; height:64px; background:rgba(255,255,255,0.85); backdrop-filter:blur(12px); border-bottom:1px solid #e2e8f0; z-index:40;"
                class="flex justify-between items-center px-8 shadow-sm">

    <div style="flex:1; max-width:480px; position:relative;">
        @if ($showSearch)
            <i class="bi bi-search"
                 style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px;"></i>
            <input type="text"
                         style="width:100%; background:#f1f5f9; border:none; border-radius:12px; padding:8px 16px 8px 36px; font-size:14px; outline:none;"
                         placeholder="{{ $placeholder }}">
        @endif
    </div>

    <div class="flex items-center gap-4 ml-6">
        <button style="position:relative; padding:8px; border-radius:8px; color:#64748b; background:none; border:none; cursor:pointer;">
            <i class="bi bi-bell-fill" style="font-size:18px;"></i>
            <span style="position:absolute; top:8px; right:8px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid white;"></span>
        </button>
        <button style="padding:8px; border-radius:8px; color:#64748b; background:none; border:none; cursor:pointer;">
            <i class="bi bi-question-circle" style="font-size:18px;"></i>
        </button>
        <div style="width:1px; height:24px; background:#e2e8f0; margin:0 4px;"></div>
        @if ($showLangDropdown)
            <button style="display:flex; align-items:center; gap:4px; padding:6px 12px; border-radius:8px; color:#1E3A5F; font-weight:600; font-size:14px; background:none; border:none; cursor:pointer;">
                ID <i class="bi bi-chevron-down" style="font-size:11px;"></i>
            </button>
        @endif
    </div>
</header>
