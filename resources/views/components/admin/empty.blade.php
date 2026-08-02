@props(['message' => 'Nothing here yet.'])

<div class="rounded-2xl border border-dashed border-deep/20 bg-white px-6 py-14 text-center">
    <x-mark class="mx-auto h-8 w-8 text-deep/25" />
    <p class="mt-4 text-sm text-muted">{{ $message }}</p>
    @if (trim($slot) !== '')
        <div class="mt-6 flex justify-center">{{ $slot }}</div>
    @endif
</div>
