@props(['name' => 'sphere', 'class' => 'h-5 w-5'])

@php
    $paths = [
        'sphere' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/>',
        'image' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 15l5-5 4 4 3-3 6 6"/>',
        'monitor' => '<rect x="2" y="4" width="20" height="14" rx="2"/><path d="M8 21h8M12 18v3"/>',
        'phone' => '<rect x="6" y="2" width="12" height="20" rx="3"/><path d="M10 18h4"/>',
        'play' => '<polygon points="6 4 20 12 6 20 6 4"/>',
        'send' => '<path d="M3 11l18-7-7 18-2.5-7.5L3 11z"/>',
        'chart' => '<path d="M3 20V10M9 20V4M15 20v-8M21 20V7"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>',
        'spark' => '<path d="M12 3l2.2 5.8L20 11l-5.8 2.2L12 19l-2.2-5.8L4 11l5.8-2.2L12 3z"/>',
        'check' => '<path d="M5 13l4 4 10-10"/>',
    ];
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor"
    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $paths[$name] ?? $paths['sphere'] !!}
</svg>
