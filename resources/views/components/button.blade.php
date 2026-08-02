@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'submit',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 rounded-full px-7 py-3 text-[0.92rem] font-semibold transition duration-200 border-2 cursor-pointer';

    $variants = [
        'primary' => 'bg-deep border-deep text-white hover:bg-deep-700 hover:border-deep-700 hover:-translate-y-0.5',
        'accent' => 'bg-violet border-violet text-white hover:bg-violet-600 hover:border-violet-600 hover:-translate-y-0.5',
        'ghost' => 'bg-transparent border-deep/25 text-deep hover:bg-lilac hover:border-deep/40',
        'light' => 'bg-white border-white text-deep hover:bg-lilac hover:border-lilac',
        'outline-light' => 'bg-transparent border-white/45 text-white hover:bg-white/10 hover:border-white',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
