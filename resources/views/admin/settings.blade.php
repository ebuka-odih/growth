<x-admin.layout title="Site settings">
    <x-slot:subtitle>Copy, contact details, social links and the Substack embed used across the site.</x-slot:subtitle>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        @foreach ($groups as $group => $fields)
            <x-admin.panel :title="$group">
                <div class="grid gap-5 {{ count($fields) > 3 ? 'sm:grid-cols-2' : '' }}">
                    @foreach ($fields as $key => $field)
                        <x-admin.field :label="$field['label']" :name="'settings.' . $key" :type="$field['type'] === 'url' ? 'url' : $field['type']"
                            :value="$values[$key] ?? null" :help="$field['help'] ?? null"
                            class="{{ $field['type'] === 'textarea' && count($fields) > 3 ? 'sm:col-span-2' : '' }}" />
                    @endforeach
                </div>
            </x-admin.panel>
        @endforeach

        <div class="flex flex-wrap gap-3">
            <x-button variant="accent" type="submit">Save settings</x-button>
            <x-button variant="ghost" :href="route('home')">View site</x-button>
        </div>
    </form>
</x-admin.layout>
