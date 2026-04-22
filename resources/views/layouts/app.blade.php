<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'PMB Online') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media (max-width: 1023px) {
                .student-sidebar {
                    display: none !important;
                }

                .student-sidebar ~ main,
                .student-sidebar ~ div,
                .ml-65 {
                    margin-left: 0 !important;
                }

                main,
                .student-sidebar ~ div {
                    min-width: 0;
                    width: 100%;
                }

                body {
                    overflow-x: hidden;
                }
            }
        </style>
    </head>
    <body class="antialiased bg-[#f7f9fc] text-on-surface">
        <div class="min-h-screen">
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </div>
        <script>
            document.addEventListener('submit', function (event) {
                const form = event.target;

                if (!(form instanceof HTMLFormElement) || form.dataset.allowResubmit === 'true') {
                    return;
                }

                if (form.dataset.submitted === 'true') {
                    event.preventDefault();
                    return;
                }

                form.dataset.submitted = 'true';

                requestAnimationFrame(function () {
                    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (button) {
                        button.setAttribute('aria-disabled', 'true');
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        button.disabled = true;
                    });
                });
            });

            document.addEventListener('click', function (event) {
                const trigger = event.target.closest('[data-dropdown-trigger]');

                document.querySelectorAll('[data-dropdown]').forEach(function (dropdown) {
                    const menu = dropdown.querySelector('[data-dropdown-menu]');
                    const button = dropdown.querySelector('[data-dropdown-trigger]');
                    const isCurrent = trigger && dropdown.contains(trigger);

                    if (!menu || !button) {
                        return;
                    }

                    if (isCurrent) {
                        const willOpen = menu.classList.contains('hidden');
                        menu.classList.toggle('hidden', !willOpen);
                        button.setAttribute('aria-expanded', String(willOpen));
                        return;
                    }

                    if (!dropdown.contains(event.target)) {
                        menu.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key !== 'Escape') {
                    return;
                }

                document.querySelectorAll('[data-dropdown]').forEach(function (dropdown) {
                    dropdown.querySelector('[data-dropdown-menu]')?.classList.add('hidden');
                    dropdown.querySelector('[data-dropdown-trigger]')?.setAttribute('aria-expanded', 'false');
                });
            });
        </script>
    </body>
</html>
