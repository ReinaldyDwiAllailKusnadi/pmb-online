@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'icon' => null,
])

@php
    $isPassword = $type === 'password';
    $inputPadding = trim(($icon ? 'pl-11' : 'pl-4') . ' ' . ($isPassword ? 'pr-12' : 'pr-4'));
@endphp

<div class="space-y-1.5">
    @if (strlen($label) > 0)
        <label for="{{ $name }}" class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ $label }}</label>
    @endif
    <div class="relative group" @if ($isPassword) x-data="{ showPassword: false }" @endif>
        @if ($icon)
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/40 group-focus-within:text-primary transition-colors">
                <x-lucide-icon :name="$icon" class="w-5 h-5" />
            </div>
        @endif
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if ($isPassword) x-bind:type="showPassword ? 'text' : 'password'" @endif
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'block w-full ' . $inputPadding . ' py-3.5 bg-surface-container-high border-0 rounded-lg text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all']) }}
        />
        @if ($isPassword)
            <button
                type="button"
                x-on:click="showPassword = !showPassword"
                x-bind:aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                class="absolute inset-y-0 right-3 flex items-center text-on-surface-variant/50 hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/30 rounded-md transition-colors"
            >
                <i class="bi text-xl" x-bind:class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
            </button>
        @endif
    </div>
</div>
