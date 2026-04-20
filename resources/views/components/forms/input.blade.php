@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'icon' => null,
])

<div class="space-y-1.5">
    @if (strlen($label) > 0)
        <label for="{{ $name }}" class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">{{ $label }}</label>
    @endif
    <div class="relative group">
        @if ($icon)
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/40 group-focus-within:text-primary transition-colors">
                <x-lucide-icon :name="$icon" class="w-5 h-5" />
            </div>
        @endif
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'block w-full pl-11 pr-4 py-3.5 bg-surface-container-high border-0 rounded-lg text-on-surface placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest transition-all']) }}
        />
    </div>
</div>