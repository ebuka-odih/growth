@props(['url', 'poster' => null, 'title' => ''])

@php
    use App\Support\Video;

    $embed = Video::embedUrl($url, autoplay: true);
    $poster = $poster ?: Video::thumbnailUrl($url);
    $fallback = Video::fallbackThumbnailUrl($url);
@endphp

@if ($embed)
    <div {{ $attributes->merge(['class' => 'relative h-full w-full overflow-hidden bg-deep']) }}>
        @if ($poster)
            {{-- Click-to-play: nothing is requested from the video host until the visitor asks for it. --}}
            <button type="button" data-video-play data-src="{{ $embed }}" data-title="{{ $title }}"
                class="group absolute inset-0 h-full w-full cursor-pointer" aria-label="Play video">
                <img src="{{ $poster }}" @if ($fallback) data-fallback="{{ $fallback }}" @endif alt=""
                    class="h-full w-full object-cover">
                <span class="absolute inset-0 bg-deep/25 transition group-hover:bg-deep/40"></span>
                <span
                    class="absolute top-1/2 left-1/2 flex h-12 w-[4.5rem] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-xl bg-black/70 transition group-hover:bg-violet">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                        <path d="M8 5.5v13l11-6.5z" />
                    </svg>
                </span>
            </button>
        @else
            <iframe src="{{ Video::embedUrl($url) }}" title="{{ $title }}" loading="lazy" allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                class="absolute inset-0 h-full w-full border-0"></iframe>
        @endif
    </div>
@endif
