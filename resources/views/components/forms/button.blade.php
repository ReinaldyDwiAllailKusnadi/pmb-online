@props([
    'variant' => 'primary',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-bold rounded-lg transition-all duration-300';
    $variants = [
        'primary' => 'bg-secondary-container text-white shadow-lg shadow-secondary-container/20 hover:scale-[1.01] hover:brightness-110 active:scale-[0.98] px-6 py-3',
        'secondary' => 'bg-white text-primary border border-primary/10 hover:bg-slate-50 hover:border-primary/20 px-6 py-3',
    ];
@endphp

<button {{ $attributes->merge(['class' => $base.' '.($variants[$variant] ?? $variants['primary'])]) }}>
    {{ $slot }}
</button>