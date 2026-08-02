@props(['tone' => 'dark'])

<div
    {{ $attributes->merge(['class' => 'flex items-center gap-3 text-[0.72rem] font-semibold uppercase tracking-[0.16em] ' . ($tone === 'light' ? 'text-lilac' : 'text-violet')]) }}>
    <x-mark class="h-4 w-4 shrink-0" />
    <span>{{ $slot }}</span>
</div>
