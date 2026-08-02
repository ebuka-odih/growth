<x-admin.layout title="Work">
    <x-slot:subtitle>Projects shown in the Work section.</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.projects.create')" class="!px-5 !py-2.5">Add project</x-button>
    </x-slot:actions>

    @if ($projects->isEmpty())
        <x-admin.empty message="No projects yet.">
            <x-button variant="accent" :href="route('admin.projects.create')">Add the first project</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Order', 'Project', 'Category', 'Year', 'Status', 'Actions']">
            @foreach ($projects as $project)
                <tr>
                    <td data-label="Order" class="px-5 py-4 text-sm text-muted">{{ $project->position }}</td>
                    <td data-label="Project" data-card-title class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if ($project->imageUrl())
                                <img src="{{ $project->imageUrl() }}" alt=""
                                    class="h-11 w-14 rounded-lg object-cover">
                            @else
                                <span class="flex h-11 w-14 items-center justify-center rounded-lg bg-lilac">
                                    <x-mark class="h-4 w-4 text-deep/40" />
                                </span>
                            @endif
                            <div>
                                <span class="block text-[0.94rem] font-medium text-deep-900">{{ $project->title }}</span>
                                <span class="block text-xs text-muted">{{ $project->disciplines }}</span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Category" class="px-5 py-4 text-sm text-muted">{{ $project->category }}</td>
                    <td data-label="Year" class="px-5 py-4 text-sm text-muted">{{ $project->year }}</td>
                    <td data-label="Status" class="px-5 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            <x-admin.badge :tone="$project->is_published ? 'live' : 'draft'">
                                {{ $project->is_published ? 'Live' : 'Hidden' }}
                            </x-admin.badge>
                            @if ($project->is_featured)
                                <x-admin.badge tone="accent">Featured</x-admin.badge>
                            @endif
                        </div>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.projects.edit', $project)" :delete="route('admin.projects.destroy', $project)"
                            :view="route('work.show', $project)" confirm="Delete this project?" />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
