<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'PMB Gateway' }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            :root {
                --navy-800: #1E3A5F;
                --navy-900: #1a2744;
                --brand-yellow: #F0A500;
                --color-primary: #1E3A5F;
                --color-accent: #F0A500;
                --color-surface-bg: #F1F5F9;
            }
            .bg-navy-800 { background-color: var(--navy-800); }
            .bg-navy-900 { background-color: var(--navy-900); }
            .bg-brand-yellow { background-color: var(--brand-yellow); }
            .text-navy-800 { color: var(--navy-800); }
            .text-navy-900 { color: var(--navy-900); }
            .text-brand-yellow { color: var(--brand-yellow); }
            .hover\:bg-brand-yellow:hover { background-color: var(--brand-yellow); }
            .bg-primary { background-color: var(--color-primary) !important; }
            .text-primary { color: var(--color-primary) !important; }
            .bg-accent { background-color: var(--color-accent) !important; }
            .text-accent { color: var(--color-accent) !important; }
            .bg-surface-bg { background-color: var(--color-surface-bg) !important; }
            .shadow-accent\/20 { box-shadow: 0 8px 24px rgba(240, 165, 0, 0.2); }
            .shadow-primary\/20 { box-shadow: 0 8px 24px rgba(30, 58, 95, 0.2); }
            .focus\:ring-accent\/20:focus { box-shadow: 0 0 0 3px rgba(240, 165, 0, 0.2); }
            @keyframes growUp {
                from { height: 0; }
                to { height: var(--bar-height); }
            }
            .bar-animate { animation: growUp 0.8s ease-out forwards; }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .page-animate { animation: fadeIn 0.7s ease forwards; }
            .hover\:-translate-y-1:hover { transform: translateY(-4px); }
            .hover\:shadow-xl:hover { box-shadow: 0 20px 40px rgba(148, 163, 184, 0.3); }
        </style>
    </head>
    <body class="bg-surface-bg text-slate-900">
        @yield('content')
    </body>
</html>
