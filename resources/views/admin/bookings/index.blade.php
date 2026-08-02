@php
    $filters = [
        ['label' => 'All', 'value' => null, 'count' => $counts['all']],
        ['label' => 'New', 'value' => 'new', 'count' => $counts['new']],
        ['label' => 'Contacted', 'value' => 'contacted', 'count' => $counts['contacted']],
        ['label' => 'Closed', 'value' => 'closed', 'count' => $counts['closed']],
    ];
@endphp

<x-admin.layout title="Enquiries">
    <x-slot:subtitle>Project briefs, cohort bookings, course enrolments and mentorship requests.</x-slot:subtitle>

    <div class="mb-6 flex flex-wrap gap-2.5">
        @foreach ($filters as $filter)
            <a href="{{ route('admin.bookings.index', array_filter(['status' => $filter['value'], 'type' => $type])) }}"
                class="rounded-full border px-4 py-2 text-[0.82rem] font-semibold transition {{ $status === $filter['value'] ? 'border-deep bg-deep text-white' : 'border-deep/15 bg-white text-deep hover:border-violet' }}">
                {{ $filter['label'] }} <span class="opacity-60">({{ $filter['count'] }})</span>
            </a>
        @endforeach

        @if ($type)
            <a href="{{ route('admin.bookings.index', array_filter(['status' => $status])) }}"
                class="rounded-full border border-violet bg-violet px-4 py-2 text-[0.82rem] font-semibold text-white">
                Type: {{ $type }} &times;
            </a>
        @endif
    </div>

    @if ($bookings->isEmpty())
        <x-admin.empty message="No enquiries match this filter." />
    @else
        <x-admin.table :headers="['Received', 'From', 'Type', 'Subject', 'Status', 'Actions']">
            @foreach ($bookings as $booking)
                <tr class="{{ $booking->status === 'new' ? 'bg-violet/4' : '' }}">
                    <td data-label="Received" class="px-5 py-4 text-sm whitespace-nowrap text-muted">
                        {{ $booking->created_at->format('j M Y') }}
                        <span class="block text-xs">{{ $booking->created_at->format('H:i') }}</span>
                    </td>
                    <td data-label="From" data-card-title class="px-5 py-4">
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                            class="block text-[0.94rem] font-medium text-deep-900 hover:text-violet">
                            {{ $booking->name }}
                        </a>
                        <span class="block text-xs text-muted">{{ $booking->email }}</span>
                    </td>
                    <td data-label="Type" class="px-5 py-4">
                        <x-admin.badge>{{ $booking->typeLabel() }}</x-admin.badge>
                        @if ($booking->cohort)
                            <span class="mt-1 block text-xs text-muted">{{ $booking->cohort->title }}</span>
                        @elseif ($booking->course)
                            <span class="mt-1 block text-xs text-muted">{{ $booking->course->title }}</span>
                        @endif
                    </td>
                    <td data-label="Subject" class="max-w-xs px-5 py-4 text-sm text-muted">
                        {{ \Illuminate\Support\Str::limit($booking->subject ?: $booking->message, 60) }}
                    </td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$booking->status === 'new' ? 'accent' : ($booking->status === 'contacted' ? 'live' : 'muted')">
                            {{ ucfirst($booking->status) }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                class="text-sm font-semibold text-deep hover:text-violet">Open</a>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                                data-confirm="Delete this enquiry? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-sm text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>

        @if ($bookings->hasPages())
            <div class="mt-8">{{ $bookings->links() }}</div>
        @endif
    @endif
</x-admin.layout>
