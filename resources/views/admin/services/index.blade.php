<x-admin.layout title="Services">
    <x-slot:subtitle>The eight service lines shown across the site.</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.services.create')" class="!px-5 !py-2.5">Add service</x-button>
    </x-slot:actions>

    @if ($services->isEmpty())
        <x-admin.empty message="No services yet.">
            <x-button variant="accent" :href="route('admin.services.create')">Add the first service</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Order', 'Service', 'Excerpt', 'Status', 'Actions']">
            @foreach ($services as $service)
                <tr>
                    <td data-label="Order" class="px-5 py-4 text-sm text-muted">{{ $service->position }}</td>
                    <td data-label="Service" data-card-title class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-lilac text-deep">
                                <x-service-icon :name="$service->icon" class="h-4 w-4" />
                            </span>
                            <div>
                                <span class="block text-[0.94rem] font-medium text-deep-900">{{ $service->title }}</span>
                                <span class="block text-xs text-muted">/{{ $service->slug }}</span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Excerpt" class="max-w-sm px-5 py-4 text-sm text-muted">
                        {{ \Illuminate\Support\Str::limit($service->excerpt, 80) }}
                    </td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$service->is_published ? 'live' : 'draft'">
                            {{ $service->is_published ? 'Live' : 'Hidden' }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.services.edit', $service)" :delete="route('admin.services.destroy', $service)"
                            :view="route('services.show', $service)" confirm="Delete this service?" />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
