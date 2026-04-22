<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'PMB Online' }}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            display: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: '#08224A',
                            background: '#F6F8FB',
                            secondary: '#F0A500',
                            'secondary-container': '#E99A00',
                            'surface-container-lowest': '#FFFFFF',
                            'surface-container-low': '#F4F7FB',
                            'surface-container-high': '#E9EDF2',
                            'surface-container-highest': '#DDE3EA',
                            'on-surface-variant': '#5F6877',
                            'outline-variant': '#CBD5E1',
                        },
                    },
                },
            };
        </script>
        <style>
            html { scroll-behavior: smooth; }
            body {
                margin: 0;
                background: #F6F8FB;
                color: #08224A;
                font-family: 'Inter', sans-serif;
            }
            a, button { transition: all 0.2s ease; }
            a:focus-visible, button:focus-visible {
                outline: 2px solid rgba(240, 165, 0, 0.7);
                outline-offset: 3px;
            }
        </style>
    </head>
    <body class="antialiased bg-background">
        @include('partials.public-navbar')
        @yield('content')
        @include('partials.public-footer')
        <script>
            document.addEventListener('click', function (event) {
                const toggle = event.target.closest('[data-public-navbar-toggle]');

                if (!toggle) {
                    return;
                }

                const navbar = toggle.closest('[data-public-navbar]');
                const menu = navbar?.querySelector('[data-public-navbar-menu]');
                const openIcon = toggle.querySelector('[data-menu-open-icon]');
                const closeIcon = toggle.querySelector('[data-menu-close-icon]');

                if (!menu) {
                    return;
                }

                const willOpen = menu.classList.contains('hidden');
                menu.classList.toggle('hidden', !willOpen);
                openIcon?.classList.toggle('hidden', willOpen);
                closeIcon?.classList.toggle('hidden', !willOpen);
                toggle.setAttribute('aria-expanded', String(willOpen));
            });

            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') {
                    return;
                }

                document.querySelectorAll('[data-public-navbar]').forEach(function (navbar) {
                    const menu = navbar.querySelector('[data-public-navbar-menu]');
                    const toggle = navbar.querySelector('[data-public-navbar-toggle]');

                    menu?.classList.add('hidden');
                    toggle?.setAttribute('aria-expanded', 'false');
                    toggle?.querySelector('[data-menu-open-icon]')?.classList.remove('hidden');
                    toggle?.querySelector('[data-menu-close-icon]')?.classList.add('hidden');
                });
            });
        </script>
    </body>
</html>
