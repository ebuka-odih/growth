<x-admin.layout title="Cohorts">
    <x-slot:subtitle>Three-week community training programmes. {{ \App\Models\Setting::get('cohort_cadence') }}</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.cohorts.create')" class="!px-5 !py-2.5">Add cohort</x-button>
    </x-slot:actions>

    @if ($cohorts->isEmpty())
        <x-admin.empty message="No cohorts yet.">
            <x-button variant="accent" :href="route('admin.cohorts.create')">Add the first cohort</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Code', 'Cohort', 'Starts', 'Status', 'Bookings', 'Visibility', 'Actions']">
            @foreach ($cohorts as $cohort)
                <tr>
                    <td data-label="Code" class="px-5 py-4">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-deep font-display text-xs text-deep">
                            {{ $cohort->code ?: '·' }}
                        </span>
                    </td>
                    <td data-label="Cohort" data-card-title class="px-5 py-4">
                        <span class="block text-[0.94rem] font-medium text-deep-900">{{ $cohort->title }}</span>
                        <span class="block text-xs text-muted">{{ $cohort->duration }}</span>
                    </td>
                    <td data-label="Starts" class="px-5 py-4 text-sm text-muted">
                        {{ $cohort->starts_on?->format('j M Y') ?: '—' }}
                    </td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$cohort->status === 'open' ? 'live' : ($cohort->status === 'closed' ? 'muted' : 'neutral')">
                            {{ $cohort->statusLabel() }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Bookings" class="px-5 py-4 text-sm">
                        <a href="{{ route('admin.bookings.index', ['type' => 'cohort']) }}"
                            class="font-semibold text-deep hover:text-violet">{{ $cohort->bookings_count }}</a>
                    </td>
                    <td data-label="Visibility" class="px-5 py-4">
                        <x-admin.badge :tone="$cohort->is_published ? 'live' : 'draft'">
                            {{ $cohort->is_published ? 'Live' : 'Hidden' }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.cohorts.edit', $cohort)" :delete="route('admin.cohorts.destroy', $cohort)"
                            :view="route('community.cohort', $cohort)" confirm="Delete this cohort? Bookings will keep their details but lose the link." />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
