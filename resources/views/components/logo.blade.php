@props(['tone' => 'dark', 'href' => null])

@php
    $wordClass = $tone === 'light' ? 'text-white' : 'text-deep';
    $markClass = $tone === 'light' ? 'text-violet' : 'text-violet';
    $tag = $href ? 'a' : 'span';
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 group']) }}>
    <x-mark class="h-8 w-8 shrink-0 {{ $markClass }} transition-transform duration-500 group-hover:rotate-180" />
    <span class="font-display text-[1.35rem] leading-none tracking-tight {{ $wordClass }}">
        Grow<span class="text-violet">sphere</span>
    </span>
</{{ $tag }}>
