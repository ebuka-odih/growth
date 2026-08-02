@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'help' => null,
    'required' => false,
    'rows' => 5,
    'options' => [],
    'placeholder' => null,
    'step' => null,
    'slugSource' => null,
    'autocomplete' => null,
])

@php
    $id = 'field-'.str_replace(['[', ']', '.'], ['-', '', '-'], $name);
    // Never echo a password back into the markup.
    $current = $type === 'password' ? null : old($name, $value);
    $base =
        'w-full rounded-lg border border-deep/15 bg-white px-3.5 py-2.5 text-[0.92rem] text-ink transition placeholder:text-muted/45 focus:border-violet focus:outline-none';
    $invalid = $errors->has($name) ? ' border-red-400' : '';
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $id }}" class="block text-[0.72rem] font-semibold tracking-[0.13em] text-deep uppercase">
        {{ $label }}@if ($required)
            <span class="text-violet">*</span>
        @endif
    </label>

    @if ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}"
            @if ($required) required @endif placeholder="{{ $placeholder }}"
            class="mt-2 {{ $base }}{{ $invalid }}">{{ $current }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $id }}" name="{{ $name }}" @if ($required) required @endif
            class="mt-2 {{ $base }}{{ $invalid }}">
            @foreach ($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" @selected((string) $current === (string) $optValue)>{{ $optLabel }}</option>
            @endforeach
        </select>
    @else
        <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}"
            value="{{ $type === 'date' && $current instanceof \DateTimeInterface ? $current->format('Y-m-d') : $current }}"
            @if ($required) required @endif @if ($step) step="{{ $step }}" @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            placeholder="{{ $placeholder }}" @if ($slugSource) data-slug-source="{{ $slugSource }}" @endif
            class="mt-2 {{ $base }}{{ $invalid }}">
    @endif

    @if ($help)
        <p class="mt-1.5 text-xs text-muted">{{ $help }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
