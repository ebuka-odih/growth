@props(['label' => 'Image', 'tone' => 'light', 'class' => 'min-h-56'])

@php
    $tones = [
        'light' => 'bg-lilac text-deep/60 border-deep/15',
        'dark' => 'bg-deep-700 text-lilac/60 border-white/10',
    ];
@endphp

<div
    {{ $attributes->merge(['class' => 'relative flex flex-col items-center justify-center gap-2 overflow-hidden border ' . ($tones[$tone] ?? $tones['light']) . ' ' . $class]) }}>
    <x-mark class="h-8 w-8 opacity-40" />
    <span class="text-[0.68rem] font-semibold uppercase tracking-[0.18em] opacity-70">{{ $label }}</span>
    <div class="pointer-events-none absolute -right-12 -bottom-12 h-44 w-44 rounded-full border border-current opacity-20"></div>
    <div class="pointer-events-none absolute -right-4 -bottom-4 h-24 w-24 rounded-full border border-current opacity-20"></div>
</div>
