<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'PMB Online') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <main class="flex min-h-screen items-center justify-center bg-background px-6 text-center">
            <section class="max-w-2xl space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Legacy View</p>
                <h1 class="text-3xl font-bold text-primary">PMB Online</h1>
                <p class="text-on-surface-variant">
                    View ini diarsipkan dan tidak digunakan oleh route aktif. Gunakan halaman publik utama atau halaman login.
                </p>
                <a href="{{ route('home') }}" class="inline-flex rounded-xl bg-primary px-5 py-3 text-sm font-bold text-white hover:opacity-90">
                    Kembali ke Beranda
                </a>
            </section>
        </main>
    </body>
</html>
