<x-admin.layout title="Courses">
    <x-slot:subtitle>Self-paced skill courses and advanced tiers.</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.courses.create')" class="!px-5 !py-2.5">Add course</x-button>
    </x-slot:actions>

    @if ($courses->isEmpty())
        <x-admin.empty message="No courses yet.">
            <x-button variant="accent" :href="route('admin.courses.create')">Add the first course</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Order', 'Course', 'Category', 'Level', 'Price', 'Status', 'Actions']">
            @foreach ($courses as $course)
                <tr>
                    <td data-label="Order" class="px-5 py-4 text-sm text-muted">{{ $course->position }}</td>
                    <td data-label="Course" data-card-title class="px-5 py-4">
                        <span class="block text-[0.94rem] font-medium text-deep-900">{{ $course->title }}</span>
                        <span class="block text-xs text-muted">{{ $course->format }}</span>
                    </td>
                    <td data-label="Category" class="px-5 py-4 text-sm text-muted">{{ $course->category }}</td>
                    <td data-label="Level" class="px-5 py-4">
                        <x-admin.badge :tone="$course->level === 'Advanced' ? 'accent' : 'neutral'">{{ $course->level }}</x-admin.badge>
                    </td>
                    <td data-label="Price" class="px-5 py-4 text-sm text-muted">
                        {{ $course->price ? '₦' . number_format((float) $course->price) : '—' }}
                    </td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$course->is_published ? 'live' : 'draft'">
                            {{ $course->is_published ? 'Live' : 'Hidden' }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.courses.edit', $course)" :delete="route('admin.courses.destroy', $course)"
                            :view="route('community.course', $course)" confirm="Delete this course?" />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
