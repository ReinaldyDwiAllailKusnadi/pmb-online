<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'PMB Online') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <main class="min-h-screen flex items-center justify-center">
            <section class="max-w-2xl text-center space-y-4">
                <h1 class="text-3xl font-bold text-primary">PMB Online</h1>
                <p class="text-on-surface-variant">
                    Halaman ini full Blade native. Silakan lanjutkan pengembangan di
                    <code class="px-2 py-1 bg-surface-container-high rounded">resources/views</code>.
                </p>
            </section>
        </main>
    </body>
</html>