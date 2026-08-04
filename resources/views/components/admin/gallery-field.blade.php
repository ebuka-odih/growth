@props(['label' => 'Images', 'name' => 'images', 'media' => null, 'limit' => 5, 'help' => null])

@php
    $media = $media ?? collect();
    $featured = old('featured_media', $media->firstWhere('is_featured', true)?->id ?? $media->first()?->id);
@endphp

<div {{ $attributes }} data-gallery data-limit="{{ $limit }}">
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-1">
        <span class="text-[0.72rem] font-semibold tracking-[0.13em] text-deep uppercase">{{ $label }}</span>
        <span class="text-xs text-muted" data-gallery-count>{{ $media->count() }} of {{ $limit }} used</span>
    </div>

    @if ($help)
        <p class="mt-1.5 text-xs text-muted">{{ $help }}</p>
    @endif

    @if ($media->isNotEmpty())
        <ul class="mt-4 grid gap-3 sm:grid-cols-3">
            @foreach ($media as $item)
                <li class="rounded-xl border border-deep/10 bg-white p-2 transition" data-gallery-item>
                    <img src="{{ $item->url() }}" alt="" class="h-24 w-full rounded-lg object-cover">

                    <label class="mt-2.5 flex cursor-pointer items-center gap-2 text-xs font-medium text-ink">
                        <input type="radio" name="featured_media" value="{{ $item->id }}"
                            @checked((string) $featured === (string) $item->id) class="accent-[#9900CC]">
                        Featured
                    </label>

                    <label class="mt-1 flex cursor-pointer items-center gap-2 text-xs text-muted">
                        <input type="checkbox" name="remove_media[]" value="{{ $item->id }}" data-gallery-remove
                            class="accent-[#9900CC]">
                        Remove
                    </label>
                </li>
            @endforeach
        </ul>
    @endif

    <input id="field-{{ $name }}" type="file" name="{{ $name }}[]" accept="image/*" multiple data-gallery-input
        class="mt-4 block w-full text-sm text-muted file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-lilac file:px-4 file:py-2 file:text-sm file:font-semibold file:text-deep hover:file:bg-violet hover:file:text-white">

    <ul class="mt-3 gap-3 sm:grid-cols-3" style="display: none" data-gallery-previews></ul>

    <p class="mt-2 hidden text-xs font-medium text-red-600" data-gallery-error></p>

    @error($name)
        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
    @error($name . '.*')
        <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
