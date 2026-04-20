@props([
    'name',
    'class' => 'w-5 h-5',
])

@php
    $icons = [
        'school' => '<path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z" /><path d="M5 13.5V17c0 1.1 3.13 2 7 2s7-.9 7-2v-3.5" />',
        'graduation-cap' => '<path d="M22 10 12 5 2 10l10 5 10-5z" /><path d="M6 12v5a6 6 0 0 0 12 0v-5" /><path d="M4 10v5" />',
        'search' => '<circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" />',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2" /><path d="m3 7 9 6 9-6" />',
        'lock' => '<rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" />',
    'user' => '<path d="M19 21a7 7 0 0 0-14 0" /><circle cx="12" cy="7" r="4" />',
        'eye' => '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z" /><circle cx="12" cy="12" r="3" />',
        'arrow-right' => '<path d="M5 12h14" /><path d="m13 5 6 7-6 7" />',
        'arrow-left' => '<path d="M19 12H5" /><path d="m11 5-6 7 6 7" />',
        'layout-dashboard' => '<rect x="3" y="3" width="7" height="9" /><rect x="14" y="3" width="7" height="5" /><rect x="14" y="12" width="7" height="9" /><rect x="3" y="14" width="7" height="7" />',
        'file-text' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><path d="M14 2v6h6" /><path d="M16 13H8" /><path d="M16 17H8" /><path d="M10 9H8" />',
        'clipboard-check' => '<rect x="9" y="2" width="6" height="4" rx="1" /><path d="M9 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3" /><path d="m9 13 2 2 4-4" />',
        'check-circle' => '<circle cx="12" cy="12" r="10" /><path d="m9 12 2 2 4-4" />',
    'check-square' => '<rect x="3" y="3" width="18" height="18" rx="2" /><path d="m9 12 2 2 4-4" />',
        'file-down' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><path d="M14 2v6h6" /><path d="M12 12v6" /><path d="m9 15 3 3 3-3" />',
        'download' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><path d="M7 10l5 5 5-5" /><path d="M12 15V3" />',
        'help-circle' => '<circle cx="12" cy="12" r="10" /><path d="M9.09 9a3 3 0 0 1 5.82 1c0 2-3 2-3 4" /><line x1="12" y1="17" x2="12" y2="17" />',
        'log-out' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><path d="m16 17 5-5-5-5" /><path d="M21 12H9" />',
        'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" /><path d="M13.73 21a2 2 0 0 1-3.46 0" />',
        'settings' => '<circle cx="12" cy="12" r="3" /><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.01a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.01a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.01a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />',
        'check' => '<path d="m5 12 5 5L20 7" />',
        'upload' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" /><path d="M17 8l-5-5-5 5" /><path d="M12 3v12" />',
        'info' => '<circle cx="12" cy="12" r="10" /><path d="M12 16v-4" /><path d="M12 8h.01" />',
    'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" /><circle cx="12" cy="13" r="3" />',
    'alert-circle' => '<circle cx="12" cy="12" r="10" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" />',
    'hourglass' => '<path d="M5 22h14" /><path d="M5 2h14" /><path d="M17 22v-4a4 4 0 0 0-4-4 4 4 0 0 0-4 4v4" /><path d="M7 2v4a4 4 0 0 0 4 4 4 4 0 0 0 4-4V2" />',
    'refresh-cw' => '<path d="M21 12a9 9 0 1 1-3-6.7" /><polyline points="21 3 21 9 15 9" />',
    'calendar-days' => '<rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4" /><path d="M8 2v4" /><path d="M3 10h18" /><path d="M8 14h.01" /><path d="M12 14h.01" /><path d="M16 14h.01" />',
    'book-open' => '<path d="M2 4h6a4 4 0 0 1 4 4v12H8a4 4 0 0 0-4 4" /><path d="M22 4h-6a4 4 0 0 0-4 4v12h4a4 4 0 0 1 4 4" />',
    'wallet' => '<path d="M20 7H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" /><path d="M16 12h2" />',
    'headphones' => '<path d="M3 18v-6a9 9 0 0 1 18 0v6" /><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3z" /><path d="M3 19a2 2 0 0 0 2 2h1v-6H3z" />',
    'share-2' => '<circle cx="18" cy="5" r="3" /><circle cx="6" cy="12" r="3" /><circle cx="18" cy="19" r="3" /><path d="M8.6 13.5 15.4 17.5" /><path d="M15.4 6.5 8.6 10.5" />',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4" /><path d="M8 2v4" /><path d="M3 10h18" />',
    'clock' => '<circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" />',
    'message-circle' => '<path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5A8.5 8.5 0 0 1 21 11v.5z" />',
            'send' => '<path d="m22 2-7 20-4-9-9-4 20-7z" /><path d="M22 2 11 13" />',
            'chevron-right' => '<path d="m9 18 6-6-6-6" />',
    'chevron-down' => '<path d="m6 9 6 6 6-6" />',
    'x' => '<path d="M18 6 6 18" /><path d="M6 6l12 12" />',
        'shield-check' => '<path d="M12 2 4 5v6c0 5.25 3.5 10.74 8 12 4.5-1.26 8-6.75 8-12V5l-8-3z" /><path d="m9 12 2 2 4-4" />',
    'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />',
    ];

    $paths = $icons[$name] ?? '';
@endphp

<svg {!! $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round']) !!}>
    {!! $paths !!}
</svg>