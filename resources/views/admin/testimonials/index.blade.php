<x-admin.layout title="Testimonials">
    <x-slot:subtitle>Client and community quotes shown on the home, community and about pages.</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.testimonials.create')" class="!px-5 !py-2.5">Add testimonial</x-button>
    </x-slot:actions>

    @if ($testimonials->isEmpty())
        <x-admin.empty message="No testimonials yet.">
            <x-button variant="accent" :href="route('admin.testimonials.create')">Add the first testimonial</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Order', 'Person', 'Quote', 'Status', 'Actions']">
            @foreach ($testimonials as $testimonial)
                <tr>
                    <td data-label="Order" class="px-5 py-4 text-sm text-muted">{{ $testimonial->position }}</td>
                    <td data-label="Person" data-card-title class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if ($testimonial->avatarUrl())
                                <img src="{{ $testimonial->avatarUrl() }}" alt=""
                                    class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-lilac font-display text-xs text-deep">
                                    {{ $testimonial->initials() }}
                                </span>
                            @endif
                            <div>
                                <span class="block text-[0.94rem] font-medium text-deep-900">{{ $testimonial->name }}</span>
                                <span class="block text-xs text-muted">
                                    {{ collect([$testimonial->role, $testimonial->company])->filter()->implode(' · ') }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Quote" class="max-w-md px-5 py-4 text-sm text-muted">
                        {{ \Illuminate\Support\Str::limit($testimonial->quote, 90) }}
                    </td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$testimonial->is_published ? 'live' : 'draft'">
                            {{ $testimonial->is_published ? 'Live' : 'Hidden' }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.testimonials.edit', $testimonial)" :delete="route('admin.testimonials.destroy', $testimonial)"
                            confirm="Delete this testimonial?" />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
