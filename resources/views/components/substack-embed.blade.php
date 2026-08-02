@props([
    'tone' => 'light',
    'height' => 320,
    'heading' => 'The GrowSphere Community newsletter',
    'compact' => false,
])

@php
    $embed = \App\Models\Setting::get('substack_embed_url');
    $home = \App\Models\Setting::get('substack_url');
    $blurb = \App\Models\Setting::get('substack_blurb');
@endphp

@if ($embed)
    <div
        {{ $attributes->merge(['class' => 'substack-frame rounded-[var(--radius-brand)] p-6 sm:p-8 ' . ($tone === 'light' ? 'bg-white border border-deep/10 shadow-[0_20px_50px_rgba(51,0,102,0.08)]' : 'bg-deep-700 border border-white/10')]) }}>
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="max-w-md">
                <x-eyebrow :tone="$tone === 'light' ? 'dark' : 'light'">Substack</x-eyebrow>
                <h3 class="mt-3 text-lg {{ $tone === 'light' ? 'text-deep-900' : 'text-white' }}">
                    {{ $heading }}
                </h3>
                @if ($blurb && !$compact)
                    <p class="mt-2 text-sm leading-relaxed {{ $tone === 'light' ? 'text-muted' : 'text-lilac/75' }}">
                        {{ $blurb }}
                    </p>
                @endif
            </div>

            @if ($home)
                <a href="{{ $home }}" target="_blank" rel="noopener"
                    class="inline-flex min-h-6 items-center text-sm font-semibold underline underline-offset-4 {{ $tone === 'light' ? 'text-violet' : 'text-lilac hover:text-white' }}">
                    Read on Substack &rarr;
                </a>
            @endif
        </div>

        <div class="mt-6">
            <iframe src="{{ $embed }}" width="480" height="{{ $height }}" title="Subscribe to the GrowSphere Community on Substack"
                frameborder="0" scrolling="no" loading="lazy"></iframe>
        </div>
    </div>
@endif
