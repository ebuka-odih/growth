@php $editing = $course->exists; @endphp

<x-admin.layout :title="$editing ? 'Edit course' : 'New course'">
    <x-slot:subtitle>{{ $editing ? $course->title : 'Add a skill course to the Community page.' }}</x-slot:subtitle>

    <form method="POST" action="{{ $editing ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
        enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Content">
                <div class="space-y-5">
                    <x-admin.field label="Title" name="title" :value="$course->title" required slug-source="#field-slug" />
                    <x-admin.field label="Summary" name="summary" type="textarea" rows="3" :value="$course->summary"
                        help="One or two lines, shown on the course cards." />
                    <x-admin.field label="Description" name="description" type="textarea" rows="6" :value="$course->description" />
                    <x-admin.field label="Learning outcomes" name="outcomes" type="textarea" rows="7" :value="$course->outcomes"
                        help="One per line. Rendered as the “What you'll learn” checklist." />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Images">
                <x-admin.gallery-field :media="$course->media" :limit="App\Models\Course::MEDIA_LIMIT"
                    help="Optional. Up to {{ App\Models\Course::MEDIA_LIMIT }} images, max 5 MB each. Tick one as the featured image — it becomes the cover shown on the course cards." />
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Details">
                <div class="space-y-5">
                    <x-admin.field label="Category" name="category" :value="$course->category"
                        placeholder="Graphic Design" />
                    <x-admin.field label="Level" name="level" type="select" :value="$course->level" required :options="['Foundation' => 'Foundation', 'Advanced' => 'Advanced']" />
                    <x-admin.field label="Format" name="format" :value="$course->format" placeholder="Self-paced" />
                    <x-admin.field label="Price" name="price" type="number" step="0.01" :value="$course->price"
                        help="Leave blank to hide the price." />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Settings">
                <div class="space-y-5">
                    <x-admin.field label="Sort order" name="position" type="number" :value="$course->position ?? 0" />
                    <x-admin.field label="Slug" name="slug" :value="$course->slug" placeholder="auto-generated" />
                    <x-admin.toggle label="Published" name="is_published" :checked="$course->is_published ?? true" />
                </div>
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create course' }}</x-button>
                <x-button variant="ghost" :href="route('admin.courses.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
