@props(['title' => null, 'description' => null])

<section {{ $attributes->merge(['class' => 'rounded-2xl border border-deep/10 bg-white p-7']) }}>
    @if ($title)
        <h2 class="text-[1.05rem] text-deep-900">{{ $title }}</h2>
    @endif
    @if ($description)
        <p class="mt-1.5 text-sm text-muted">{{ $description }}</p>
    @endif

    <div class="{{ $title || $description ? 'mt-6' : '' }}">{{ $slot }}</div>
</section>
