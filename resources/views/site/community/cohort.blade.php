<x-layouts.site :title="$cohort->title" :description="$cohort->tagline">
    <x-page-header :eyebrow="'Cohort ' . ($cohort->code ?: '')" :title="$cohort->title" :back="route('community.index')"
        back-label="All programmes">
        {{ $cohort->tagline }}

        <x-slot:actions>
            @if ($cohort->isBookable())
                <x-button variant="light" :href="route('contact', ['type' => 'cohort', 'cohort' => $cohort->id])">
                    Book this cohort
                </x-button>
            @else
                <x-button variant="light" :href="route('contact', ['type' => 'cohort'])">Join the waitlist</x-button>
            @endif
            <x-button variant="outline-light" :href="route('contact', ['type' => 'mentorship'])">Book mentorship instead</x-button>
        </x-slot:actions>
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-14 px-6 lg:grid-cols-[1.4fr_1fr]">
            <div class="reveal">
                <div class="prose-brand">
                    @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $cohort->description) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>

                @if ($cohort->curriculumList())
                    <h2 class="mt-12 text-xl text-deep-900">What we cover</h2>
                    <ol class="mt-6 space-y-3">
                        @foreach ($cohort->curriculumList() as $i => $topic)
                            <li
                                class="flex items-start gap-4 rounded-xl border border-deep/10 bg-white px-5 py-4 text-[0.94rem]">
                                <span
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lilac font-display text-xs text-deep">
                                    {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                {{ $topic }}
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>

            <aside class="reveal space-y-5">
                <div class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                    <dl>
                        @php
                            $facts = array_filter([
                                'Status' => $cohort->statusLabel(),
                                'Duration' => $cohort->duration,
                                'Starts' => $cohort->starts_on?->format('j F Y'),
                                'Certificate' => $cohort->has_certificate ? 'Awarded on completion' : null,
                                'Fee' => $cohort->price ? '₦' . number_format((float) $cohort->price) : null,
                            ]);
                        @endphp
                        @foreach ($facts as $label => $value)
                            <div class="border-b border-deep/10 py-3 first:pt-0 last:border-0 last:pb-0">
                                <dt class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                    {{ $label }}
                                </dt>
                                <dd class="mt-1 text-[0.94rem] text-ink">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <x-button variant="accent" :href="route('contact', ['type' => 'cohort', 'cohort' => $cohort->id])"
                        class="mt-6 w-full">
                        {{ $cohort->isBookable() ? 'Book your place' : 'Join the waitlist' }}
                    </x-button>
                    <p class="mt-3 text-center text-xs text-muted">
                        {{ \App\Models\Setting::get('cohort_cadence') }}
                    </p>
                </div>

                @if ($others->isNotEmpty())
                    <div class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                        <h3 class="text-[1rem] font-semibold text-deep-900">Other programmes</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($others as $other)
                                <li>
                                    <a href="{{ route('community.cohort', $other) }}"
                                        class="flex min-h-6 items-center gap-3 py-1 text-[0.92rem] text-ink hover:text-violet">
                                        <span
                                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lilac font-display text-[0.65rem] text-deep">
                                            {{ $other->code ?: '·' }}
                                        </span>
                                        {{ $other->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-substack-embed class="reveal" compact heading="Get cohort announcements" :height="260" />
            </aside>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
