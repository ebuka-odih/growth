@props(['tone' => 'neutral'])

@php
    $tones = [
        'neutral' => 'bg-lilac text-deep',
        'live' => 'bg-emerald-100 text-emerald-800',
        'draft' => 'bg-amber-100 text-amber-800',
        'accent' => 'bg-violet text-white',
        'muted' => 'bg-deep/5 text-muted',
    ];
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-block rounded-full px-2.5 py-1 text-[0.68rem] font-semibold whitespace-nowrap ' . ($tones[$tone] ?? $tones['neutral'])]) }}>
    {{ $slot }}
</span>
