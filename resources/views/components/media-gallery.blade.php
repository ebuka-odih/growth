@props([
    'media' => null,
    'videoUrl' => null,
    'title' => '',
    'placeholder' => 'Image',
    'aspect' => 'aspect-[16/10]',
])

@php
    use App\Support\Video;

    $media = ($media ?? collect())->values();
    $hasVideo = Video::isSupported($videoUrl);

    // The video leads when there is one; the featured image is already first in $media.
    $items = collect();

    if ($hasVideo) {
        $items->push([
            'kind' => 'video',
            'thumb' => Video::thumbnailUrl($videoUrl) ?: $media->first()?->url(),
            'fallback' => Video::fallbackThumbnailUrl($videoUrl),
        ]);
    }

    foreach ($media as $item) {
        $items->push(['kind' => 'image', 'thumb' => $item->url(), 'fallback' => null]);
    }

    $stageAspect = $hasVideo ? 'aspect-video' : $aspect;
@endphp

<div {{ $attributes }} data-gallery-view>
    <div class="relative w-full overflow-hidden rounded-[var(--radius-brand)] {{ $stageAspect }}">
        @forelse ($items as $index => $item)
            <div class="absolute inset-0" data-gallery-panel="{{ $index }}"
                @if ($index) style="display: none" @endif>
                @if ($item['kind'] === 'video')
                    <x-video-preview :url="$videoUrl" :poster="$item['thumb']" :title="$title" />
                @else
                    <img src="{{ $item['thumb'] }}" alt="{{ $title }}" class="h-full w-full object-cover"
                        @if ($index) loading="lazy" @endif>
                @endif
            </div>
        @empty
            <x-placeholder :label="$placeholder" class="absolute inset-0 h-full border-0" />
        @endforelse
    </div>

    @if ($items->count() > 1)
        <div class="mt-4 flex gap-3 overflow-x-auto pb-1">
            @foreach ($items as $index => $item)
                <button type="button" data-gallery-thumb="{{ $index }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    class="relative h-16 w-24 shrink-0 cursor-pointer overflow-hidden rounded-xl border-2 transition aria-[current=true]:border-violet aria-[current=false]:border-transparent aria-[current=false]:opacity-70 hover:opacity-100">
                    <img src="{{ $item['thumb'] }}"
                        @if ($item['fallback']) data-fallback="{{ $item['fallback'] }}" @endif alt=""
                        class="h-full w-full object-cover" loading="lazy">
                    @if ($item['kind'] === 'video')
                        <span class="absolute inset-0 flex items-center justify-center bg-deep/35">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-white">
                                <path d="M8 5.5v13l11-6.5z" />
                            </svg>
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    @endif
</div>
