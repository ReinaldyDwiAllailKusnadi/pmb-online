{{-- Legacy fallback view only. The active public homepage is resources/views/public/home.blade.php. --}}
@extends('layouts.public')

@section('title', 'PMB Online')

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="rounded-3xl bg-white border border-slate-100 shadow-[0_2px_12px_rgba(30,58,95,0.08)] p-10 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-secondary mb-4">
                Legacy View
            </p>
            <h1 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                Halaman utama PMB Online sudah dipindahkan.
            </h1>
            <p class="text-slate-600 max-w-2xl mx-auto mb-8">
                Gunakan halaman publik utama yang aktif untuk melihat landing page terbaru.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3 font-semibold text-white transition-colors hover:bg-primary/90">
                Buka Beranda
            </a>
        </div>
    </section>
@endsection
