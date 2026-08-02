<x-admin.layout :title="$booking->name">
    <x-slot:subtitle>{{ $booking->typeLabel() }} · {{ $booking->created_at->format('j F Y, H:i') }}</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="ghost" :href="route('admin.bookings.index')" class="!px-5 !py-2.5">Back to enquiries</x-button>
        <x-button variant="accent" :href="'mailto:' . $booking->email . '?subject=' . rawurlencode('Re: ' . ($booking->subject ?: 'Your GrowSphere enquiry'))"
            class="!px-5 !py-2.5">Reply by email</x-button>
    </x-slot:actions>

    <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        <div class="space-y-6">
            <x-admin.panel title="Message">
                @if ($booking->subject)
                    <p class="mb-4 text-[0.94rem] font-semibold text-deep-900">{{ $booking->subject }}</p>
                @endif
                <div class="prose-brand text-[0.95rem]">
                    @foreach (preg_split('/\r\n|\n/', (string) $booking->message) as $line)
                        @if (trim($line))
                            <p>{{ trim($line) }}</p>
                        @endif
                    @endforeach
                </div>
            </x-admin.panel>

            <x-admin.panel title="Status & notes">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <x-admin.field label="Status" name="status" type="select" :value="$booking->status" required :options="['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed']" />
                    <x-admin.field label="Internal notes" name="admin_notes" type="textarea" rows="5" :value="$booking->admin_notes"
                        help="Only visible here." />

                    <x-button variant="accent" type="submit">Save</x-button>
                </form>
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Contact">
                <dl class="space-y-4 text-[0.94rem]">
                    @php
                        $details = array_filter([
                            'Name' => $booking->name,
                            'Email' => $booking->email,
                            'Phone' => $booking->phone,
                            'Company' => $booking->company,
                            'Cohort' => $booking->cohort?->title,
                            'Course' => $booking->course?->title,
                        ]);
                    @endphp
                    @foreach ($details as $label => $value)
                        <div>
                            <dt class="text-[0.68rem] font-semibold tracking-[0.13em] text-violet uppercase">{{ $label }}</dt>
                            <dd class="mt-1 break-words text-ink">
                                @if ($label === 'Email')
                                    <a href="mailto:{{ $value }}" class="hover:text-violet">{{ $value }}</a>
                                @elseif ($label === 'Phone')
                                    <a href="tel:{{ $value }}" class="hover:text-violet">{{ $value }}</a>
                                @else
                                    {{ $value }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </x-admin.panel>

            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                data-confirm="Delete this enquiry? This cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full cursor-pointer rounded-full border-2 border-red-200 px-6 py-3 text-sm font-semibold text-red-600 transition hover:border-red-400 hover:bg-red-50">
                    Delete enquiry
                </button>
            </form>
        </div>
    </div>
</x-admin.layout>
