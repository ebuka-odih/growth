@props([
    'eyebrow' => null,
    'title' => null,
    'tone' => 'dark',
    'align' => 'left',
])

<div
    {{ $attributes->merge(['class' => 'reveal max-w-2xl ' . ($align === 'center' ? 'mx-auto text-center' : '')]) }}>
    @if ($eyebrow)
        <x-eyebrow :tone="$tone" class="{{ $align === 'center' ? 'justify-center' : '' }}">{{ $eyebrow }}</x-eyebrow>
    @endif

    @if ($title)
        <h2
            class="mt-5 text-[clamp(1.7rem,3.1vw,2.5rem)] {{ $tone === 'light' ? 'text-white' : 'text-deep-900' }}">
            {{ $title }}
        </h2>
    @endif

    @if (trim($slot) !== '')
        <p class="mt-4 text-[1.02rem] leading-relaxed {{ $tone === 'light' ? 'text-lilac/80' : 'text-muted' }}">
            {{ $slot }}
        </p>
    @endif
</div>
