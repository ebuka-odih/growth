<x-admin.layout title="Dashboard">
    <x-slot:subtitle>Everything on the public site, editable from here.</x-slot:subtitle>

    <x-slot:actions>
        <x-button variant="ghost" :href="route('admin.posts.create')" class="!px-5 !py-2.5">New post</x-button>
        <x-button variant="accent" :href="route('admin.projects.create')" class="!px-5 !py-2.5">New project</x-button>
    </x-slot:actions>

    <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
        @foreach ($stats as $stat)
            <a href="{{ $stat['route'] }}"
                class="rounded-2xl border p-5 transition hover:-translate-y-1 hover:shadow-[0_18px_36px_rgba(51,0,102,0.1)] sm:p-6 {{ ($stat['accent'] ?? false) && $stat['value'] > 0 ? 'border-violet bg-violet text-white' : 'border-deep/10 bg-white' }}">
                <span
                    class="font-display text-2xl sm:text-3xl {{ ($stat['accent'] ?? false) && $stat['value'] > 0 ? 'text-white' : 'text-deep' }}">
                    {{ $stat['value'] }}
                </span>
                <span
                    class="mt-1.5 block text-sm {{ ($stat['accent'] ?? false) && $stat['value'] > 0 ? 'text-white/80' : 'text-muted' }}">
                    {{ $stat['label'] }}
                </span>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[1.4fr_1fr]">
        <x-admin.panel title="Recent enquiries" description="Project briefs, cohort bookings and mentorship requests.">
            @if ($recentBookings->isEmpty())
                <p class="text-sm text-muted">No enquiries yet.</p>
            @else
                <ul class="divide-y divide-deep/8">
                    @foreach ($recentBookings as $booking)
                        <li class="flex items-start justify-between gap-4 py-3.5 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                    class="text-[0.94rem] font-medium text-deep-900 hover:text-violet">
                                    {{ $booking->name }}
                                </a>
                                <p class="mt-0.5 truncate text-xs text-muted">
                                    {{ $booking->typeLabel() }}
                                    @if ($booking->cohort)
                                        · {{ $booking->cohort->title }}
                                    @endif
                                    · {{ $booking->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <x-admin.badge :tone="$booking->status === 'new' ? 'accent' : 'muted'">
                                {{ ucfirst($booking->status) }}
                            </x-admin.badge>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('admin.bookings.index') }}"
                    class="mt-5 inline-block text-sm font-semibold text-violet">All enquiries &rarr;</a>
            @endif
        </x-admin.panel>

        <div class="space-y-6">
            <x-admin.panel title="Open cohorts">
                @if ($openCohorts->isEmpty())
                    <p class="text-sm text-muted">No cohorts are accepting bookings.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($openCohorts as $cohort)
                            <li class="flex items-center justify-between gap-3">
                                <a href="{{ route('admin.cohorts.edit', $cohort) }}"
                                    class="text-[0.92rem] text-ink hover:text-violet">
                                    {{ $cohort->code ? $cohort->code . ' — ' : '' }}{{ $cohort->title }}
                                </a>
                                <x-admin.badge :tone="$cohort->status === 'open' ? 'live' : 'neutral'">
                                    {{ $cohort->statusLabel() }}
                                </x-admin.badge>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.panel>

            <x-admin.panel title="Drafts">
                @if ($draftPosts->isEmpty())
                    <p class="text-sm text-muted">No unpublished posts.</p>
                @else
                    <ul class="space-y-3">
                        @foreach ($draftPosts as $post)
                            <li>
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                    class="text-[0.92rem] text-ink hover:text-violet">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.panel>
        </div>
    </div>
</x-admin.layout>
