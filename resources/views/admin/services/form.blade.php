@php
    $editing = $service->exists;
    $icons = ['sphere', 'image', 'monitor', 'phone', 'play', 'send', 'chart', 'user', 'spark'];
@endphp

<x-admin.layout :title="$editing ? 'Edit service' : 'New service'">
    <x-slot:subtitle>{{ $editing ? $service->title : 'Add a service line to the site.' }}</x-slot:subtitle>

    <form method="POST"
        action="{{ $editing ? route('admin.services.update', $service) : route('admin.services.store') }}"
        class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Content">
                <div class="space-y-5">
                    <x-admin.field label="Title" name="title" :value="$service->title" required
                        slug-source="#field-slug" />
                    <x-admin.field label="Excerpt" name="excerpt" type="textarea" rows="2" :value="$service->excerpt" required
                        help="One line, shown on the services grid and cards." />
                    <x-admin.field label="Description" name="description" type="textarea" rows="6" :value="$service->description"
                        help="Shown on the service page. Separate paragraphs with a blank line." />
                    <x-admin.field label="Deliverables" name="deliverables" type="textarea" rows="7" :value="$service->deliverables"
                        help="One per line. Rendered as the “What's included” checklist." />
                </div>
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Settings">
                <div class="space-y-5">
                    <x-admin.field label="Icon" name="icon" type="select" :value="$service->icon" required
                        :options="collect($icons)->mapWithKeys(fn($i) => [$i => ucfirst($i)])->all()" />
                    <x-admin.field label="Sort order" name="position" type="number" :value="$service->position ?? 0"
                        help="Lower numbers appear first." />
                    <x-admin.field label="Slug" name="slug" :value="$service->slug" placeholder="auto-generated"
                        help="Leave blank to generate from the title." />
                    <x-admin.toggle label="Published" name="is_published" :checked="$service->is_published ?? true" />
                </div>
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create service' }}</x-button>
                <x-button variant="ghost" :href="route('admin.services.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
