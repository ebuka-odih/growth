@props(['label', 'name', 'checked' => false, 'help' => null])

<label {{ $attributes->merge(['class' => 'flex cursor-pointer items-start gap-3']) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $checked))
        class="mt-0.5 h-4.5 w-4.5 accent-[#9900CC]">
    <span>
        <span class="block text-[0.9rem] font-medium text-ink">{{ $label }}</span>
        @if ($help)
            <span class="mt-0.5 block text-xs text-muted">{{ $help }}</span>
        @endif
    </span>
</label>
