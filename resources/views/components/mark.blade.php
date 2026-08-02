@props(['class' => 'h-7 w-7'])

{{-- The GrowSphere spiral mark: concentric arcs closing on a solid core. --}}
<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 100 100" fill="none" aria-hidden="true">
    <circle cx="50" cy="50" r="9" fill="currentColor" />
    <path d="M50 32a18 18 0 1 1-18 18" stroke="currentColor" stroke-width="7" stroke-linecap="round" />
    <path d="M50 20a30 30 0 1 1-30 30" stroke="currentColor" stroke-width="7" stroke-linecap="round" />
    <path d="M50 8a42 42 0 1 1-42 42" stroke="currentColor" stroke-width="7" stroke-linecap="round" />
</svg>
