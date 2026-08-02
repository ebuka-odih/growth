@props(['label' => 'Image', 'name' => 'image', 'current' => null, 'help' => null])

<div {{ $attributes }}>
    <span class="block text-[0.72rem] font-semibold tracking-[0.13em] text-deep uppercase">{{ $label }}</span>

    <div class="mt-3 flex flex-wrap items-start gap-5">
        @if ($current)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($current) }}" alt=""
                class="h-24 w-32 rounded-lg border border-deep/10 object-cover">
        @endif

        <div class="min-w-0 grow">
            <input id="field-{{ $name }}" type="file" name="{{ $name }}" accept="image/*"
                class="block w-full text-sm text-muted file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-lilac file:px-4 file:py-2 file:text-sm file:font-semibold file:text-deep hover:file:bg-violet hover:file:text-white">

            @if ($help)
                <p class="mt-2 text-xs text-muted">{{ $help }}</p>
            @endif

            @if ($current)
                <label class="mt-3 flex cursor-pointer items-center gap-2 text-sm text-muted">
                    <input type="checkbox" name="{{ $name }}_remove" value="1" class="accent-[#9900CC]">
                    Remove current image
                </label>
            @endif

            @error($name)
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
