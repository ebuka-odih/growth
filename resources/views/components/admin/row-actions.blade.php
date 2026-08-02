@props(['edit', 'delete', 'confirm' => 'Delete this item? This cannot be undone.', 'view' => null])

<div class="flex items-center justify-end gap-3">
    @if ($view)
        <a href="{{ $view }}" target="_blank" rel="noopener" class="text-sm text-muted hover:text-violet">View</a>
    @endif
    <a href="{{ $edit }}" class="text-sm font-semibold text-deep hover:text-violet">Edit</a>
    <form method="POST" action="{{ $delete }}" data-confirm="{{ $confirm }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="cursor-pointer text-sm text-red-600 hover:text-red-800">Delete</button>
    </form>
</div>
