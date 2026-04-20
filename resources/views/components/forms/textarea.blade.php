@props([
    'name',
    'label',
    'rows' => 3,
    'value' => null,
    'placeholder' => '',
])

<div class="space-y-2">
    <label for="{{ $name }}" class="text-xs font-bold text-primary uppercase tracking-wider">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full p-4 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary focus:bg-white transition-all font-medium']) }}
    >{{ old($name, $value) }}</textarea>
</div>