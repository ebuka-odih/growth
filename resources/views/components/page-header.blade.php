@props([
    'eyebrow' => null,
    'title' => null,
    'back' => null,
    'backLabel' => 'Back',
])

<section class="relative overflow-hidden bg-deep-900 pt-16 pb-20 text-white">
    <div class="pointer-events-none absolute inset-0 brand-pattern"></div>
    <div
        class="pointer-events-none absolute -top-32 -right-24 h-[380px] w-[380px] rounded-full border border-white/10"></div>

    <div class="relative mx-auto max-w-6xl px-6">
        @if ($back)
            <a href="{{ $back }}"
                class="mb-7 inline-flex min-h-6 items-center gap-2 text-sm font-medium text-lilac/70 hover:text-white">
                &larr; {{ $backLabel }}
            </a>
        @endif

        @if ($eyebrow)
            <x-eyebrow tone="light">{{ $eyebrow }}</x-eyebrow>
        @endif

        @if ($title)
            <h1 class="mt-5 max-w-3xl text-[clamp(2rem,4vw,3.1rem)]">{{ $title }}</h1>
        @endif

        @if (trim($slot) !== '')
            <div class="mt-5 max-w-2xl text-[1.02rem] leading-relaxed text-lilac/75">{{ $slot }}</div>
        @endif

        @isset($actions)
            <div class="mt-9 flex flex-wrap gap-3">{{ $actions }}</div>
        @endisset
    </div>
</section>
