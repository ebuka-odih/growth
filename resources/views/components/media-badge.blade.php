@props(['project'])

@php
    $extra = $project->media->count() - 1;
@endphp

@if ($project->hasVideo() || $extra > 0)
    <div {{ $attributes->merge(['class' => 'pointer-events-none absolute top-3 right-3 flex items-center gap-1.5']) }}>
        @if ($project->hasVideo())
            <span
                class="inline-flex items-center gap-1 rounded-full bg-black/65 px-2.5 py-1 text-[0.66rem] font-semibold tracking-[0.08em] text-white uppercase backdrop-blur-sm">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-3 w-3" aria-hidden="true">
                    <path d="M8 5.5v13l11-6.5z" />
                </svg>
                Video
            </span>
        @endif

        @if ($extra > 0)
            <span
                class="inline-flex items-center rounded-full bg-black/65 px-2.5 py-1 text-[0.66rem] font-semibold text-white backdrop-blur-sm">
                +{{ $extra }}
            </span>
        @endif
    </div>
@endif
