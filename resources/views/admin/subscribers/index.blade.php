<x-admin.layout title="Subscribers">
    <x-slot:subtitle>People who signed up through the site footer. Substack keeps its own separate list.</x-slot:subtitle>
    <x-slot:actions>
        @if ($subscribers->total() > 0)
            <x-button variant="ghost" :href="route('admin.subscribers.export')" class="!px-5 !py-2.5">Export CSV</x-button>
        @endif
        @if (\App\Models\Setting::get('substack_url'))
            <x-button variant="accent" :href="\App\Models\Setting::get('substack_url')" class="!px-5 !py-2.5">Open Substack</x-button>
        @endif
    </x-slot:actions>

    @if ($subscribers->isEmpty())
        <x-admin.empty message="No one has subscribed through the site footer yet." />
    @else
        <x-admin.table :headers="['Email', 'Name', 'Source', 'Subscribed', 'Actions']">
            @foreach ($subscribers as $subscriber)
                <tr>
                    <td data-label="Email" data-card-title class="px-5 py-4 text-[0.94rem] font-medium text-deep-900">{{ $subscriber->email }}</td>
                    <td data-label="Name" class="px-5 py-4 text-sm text-muted">{{ $subscriber->name ?: '—' }}</td>
                    <td data-label="Source" class="px-5 py-4"><x-admin.badge>{{ $subscriber->source }}</x-admin.badge></td>
                    <td data-label="Subscribed" class="px-5 py-4 text-sm text-muted">{{ $subscriber->created_at->format('j M Y') }}</td>
                    <td data-label="Actions" class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}"
                            data-confirm="Remove this subscriber?" class="flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-sm text-red-600 hover:text-red-800">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        @if ($subscribers->hasPages())
            <div class="mt-8">{{ $subscribers->links() }}</div>
        @endif
    @endif
</x-admin.layout>
