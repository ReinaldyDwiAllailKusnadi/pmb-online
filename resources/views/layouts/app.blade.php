<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'PMB Online') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        </script>
    </body>
</html>
