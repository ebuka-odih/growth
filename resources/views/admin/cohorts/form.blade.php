@php $editing = $cohort->exists; @endphp

<x-admin.layout :title="$editing ? 'Edit cohort' : 'New cohort'">
    <x-slot:subtitle>{{ $editing ? $cohort->title : 'Add a training programme to the Community page.' }}</x-slot:subtitle>

    <form method="POST" action="{{ $editing ? route('admin.cohorts.update', $cohort) : route('admin.cohorts.store') }}"
        class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Content">
                <div class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-[120px_1fr]">
                        <x-admin.field label="Code" name="code" :value="$cohort->code" placeholder="1.0" />
                        <x-admin.field label="Title" name="title" :value="$cohort->title" required slug-source="#field-slug" />
                    </div>
                    <x-admin.field label="Tagline" name="tagline" :value="$cohort->tagline"
                        help="One line, shown on the cohort cards." />
                    <x-admin.field label="Description" name="description" type="textarea" rows="6" :value="$cohort->description" />
                    <x-admin.field label="Curriculum" name="curriculum" type="textarea" rows="7" :value="$cohort->curriculum"
                        help="One topic per line. Rendered as the numbered “What we cover” list." />
                </div>
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Programme">
                <div class="space-y-5">
                    <x-admin.field label="Status" name="status" type="select" :value="$cohort->status" required :options="[
                        'upcoming' => 'Upcoming',
                        'open' => 'Enrolling now',
                        'running' => 'In session',
                        'closed' => 'Closed',
                    ]"
                        help="Upcoming and Enrolling now both accept bookings." />
                    <x-admin.field label="Duration" name="duration" :value="$cohort->duration" required />
                    <x-admin.field label="Start date" name="starts_on" type="date" :value="$cohort->starts_on" />
                    <x-admin.field label="Fee" name="price" type="number" step="0.01" :value="$cohort->price"
                        help="Leave blank to hide the fee." />
                    <x-admin.toggle label="Awards a certificate" name="has_certificate" :checked="$cohort->has_certificate ?? true" />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Settings">
                <div class="space-y-5">
                    <x-admin.field label="Sort order" name="position" type="number" :value="$cohort->position ?? 0" />
                    <x-admin.field label="Slug" name="slug" :value="$cohort->slug" placeholder="auto-generated" />
                    <x-admin.toggle label="Published" name="is_published" :checked="$cohort->is_published ?? true" />
                </div>
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create cohort' }}</x-button>
                <x-button variant="ghost" :href="route('admin.cohorts.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
