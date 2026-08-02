@php $editing = $project->exists; @endphp

<x-admin.layout :title="$editing ? 'Edit project' : 'New project'">
    <x-slot:subtitle>{{ $editing ? $project->title : 'Add a case study to the Work section.' }}</x-slot:subtitle>

    <form method="POST"
        action="{{ $editing ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
        enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Content">
                <div class="space-y-5">
                    <x-admin.field label="Title" name="title" :value="$project->title" required slug-source="#field-slug" />
                    <x-admin.field label="Summary" name="summary" type="textarea" rows="3" :value="$project->summary"
                        help="Shown under the project title on the detail page." />
                    <x-admin.field label="Case study" name="body" type="textarea" rows="10" :value="$project->body"
                        help="Optional long-form write-up. Separate paragraphs with a blank line." />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Cover image">
                <x-admin.image-field label="Image" name="image" :current="$project->image"
                    help="Landscape works best (roughly 3:2). Max 5 MB." />
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Details">
                <div class="space-y-5">
                    <x-admin.field label="Client" name="client" :value="$project->client" />
                    <x-admin.field label="Category" name="category" :value="$project->category"
                        help="Used for the filter chips, e.g. Brand Identity, Website, Motion." />
                    <x-admin.field label="Disciplines" name="disciplines" :value="$project->disciplines"
                        placeholder="Logo · Style guide · Messaging" help="The small line under the card title." />
                    <x-admin.field label="Year" name="year" :value="$project->year" />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Settings">
                <div class="space-y-5">
                    <x-admin.field label="Sort order" name="position" type="number" :value="$project->position ?? 0" />
                    <x-admin.field label="Slug" name="slug" :value="$project->slug" placeholder="auto-generated" />
                    <x-admin.toggle label="Published" name="is_published" :checked="$project->is_published ?? true" />
                    <x-admin.toggle label="Featured" name="is_featured" :checked="$project->is_featured ?? false"
                        help="Marks the project as a highlight." />
                </div>
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create project' }}</x-button>
                <x-button variant="ghost" :href="route('admin.projects.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
