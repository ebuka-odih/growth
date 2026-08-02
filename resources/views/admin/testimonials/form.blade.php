@php $editing = $testimonial->exists; @endphp

<x-admin.layout :title="$editing ? 'Edit testimonial' : 'New testimonial'">
    <x-slot:subtitle>{{ $editing ? $testimonial->name : 'Add a client or community quote.' }}</x-slot:subtitle>

    <form method="POST"
        action="{{ $editing ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
        enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Quote">
                <div class="space-y-5">
                    <x-admin.field label="Quote" name="quote" type="textarea" rows="5" :value="$testimonial->quote" required
                        help="Quotation marks are added automatically." />
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-admin.field label="Name" name="name" :value="$testimonial->name" required />
                        <x-admin.field label="Role" name="role" :value="$testimonial->role" />
                    </div>
                    <x-admin.field label="Company" name="company" :value="$testimonial->company" />
                </div>
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Photo">
                <x-admin.image-field label="Avatar" name="avatar" :current="$testimonial->avatar"
                    help="Square works best. Falls back to initials. Max 2 MB." />
            </x-admin.panel>

            <x-admin.panel title="Settings">
                <div class="space-y-5">
                    <x-admin.field label="Sort order" name="position" type="number" :value="$testimonial->position ?? 0" />
                    <x-admin.toggle label="Published" name="is_published" :checked="$testimonial->is_published ?? true" />
                </div>
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create testimonial' }}</x-button>
                <x-button variant="ghost" :href="route('admin.testimonials.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
