@php use App\Models\Setting; @endphp

<x-layouts.site title="Community"
    description="Cohort-based programs, premium skill courses, one-on-one mentorship and certificates — inside the GrowSphere Community.">

    <x-page-header eyebrow="GrowSphere Community" title="A community built for personal and financial growth.">
        {{ Setting::get('community_mission') }}

        <x-slot:actions>
            <x-button variant="light" :href="route('contact', ['type' => 'cohort'])">Book a cohort</x-button>
            <x-button variant="outline-light" :href="route('contact', ['type' => 'mentorship'])">Book 1-on-1 mentorship</x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- Cohorts -------------------------------------------------------------- --}}
    <section id="cohorts" class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="Trainings" title="Learn & grow with our cohorts.">
                Structured 3-week training programs with a certificate at the end of every one.
                {{ Setting::get('cohort_cadence') }}
            </x-section-head>

            <div class="mt-14 grid gap-5 lg:grid-cols-3">
                @foreach ($cohorts as $cohort)
                    <article
                        class="reveal flex flex-col rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8 transition hover:-translate-y-1.5 hover:border-violet hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                        <div class="flex items-center justify-between">
                            <span
                                class="flex h-12 w-12 items-center justify-center rounded-full border-2 border-deep font-display text-sm text-deep">
                                {{ $cohort->code ?: '·' }}
                            </span>
                            <span
                                class="rounded-full px-3 py-1 text-[0.68rem] font-semibold {{ $cohort->status === 'open' ? 'bg-violet text-white' : 'border border-deep/10 bg-lilac-soft text-deep' }}">
                                {{ $cohort->statusLabel() }}
                            </span>
                        </div>

                        <h3 class="mt-6 text-[1.15rem] font-semibold text-deep-900">
                            <a href="{{ route('community.cohort', $cohort) }}" class="hover:text-violet">
                                {{ $cohort->title }}
                            </a>
                        </h3>
                        <p class="mt-2.5 grow text-[0.92rem] leading-relaxed text-muted">
                            {{ $cohort->tagline ?: \Illuminate\Support\Str::limit($cohort->description, 130) }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <span
                                class="rounded-full border border-deep/10 bg-lilac-soft px-3 py-1 text-[0.7rem] font-semibold text-deep">
                                {{ $cohort->duration }}
                            </span>
                            @if ($cohort->has_certificate)
                                <span
                                    class="rounded-full border border-deep/10 bg-lilac-soft px-3 py-1 text-[0.7rem] font-semibold text-deep">
                                    Certificate
                                </span>
                            @endif
                            @if ($cohort->starts_on)
                                <span
                                    class="rounded-full border border-deep/10 bg-lilac-soft px-3 py-1 text-[0.7rem] font-semibold text-deep">
                                    Starts {{ $cohort->starts_on->format('j M Y') }}
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('community.cohort', $cohort) }}"
                            class="mt-6 inline-flex min-h-6 items-center text-sm font-semibold text-violet">View programme &rarr;</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Courses -------------------------------------------------------------- --}}
    <section id="courses" class="bg-lilac-soft py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="Skill courses" title="Premium skill courses, self-paced.">
                Graphic design, motion design and website design — with tutorials, downloadable resources and advanced
                tiers when you're ready to go deeper.
            </x-section-head>

            <div class="mt-14 grid gap-5 sm:grid-cols-2">
                @foreach ($courses as $course)
                    <article
                        class="reveal flex flex-col rounded-[var(--radius-brand)] bg-white p-8 transition hover:-translate-y-1.5 hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                        <div class="flex flex-wrap items-center gap-2">
                            @if ($course->category)
                                <span class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                    {{ $course->category }}
                                </span>
                            @endif
                            <span
                                class="rounded-full border border-deep/10 px-2.5 py-0.5 text-[0.66rem] font-semibold text-deep">
                                {{ $course->level }}
                            </span>
                        </div>

                        <h3 class="mt-4 text-[1.1rem] font-semibold text-deep-900">
                            <a href="{{ route('community.course', $course) }}" class="hover:text-violet">
                                {{ $course->title }}
                            </a>
                        </h3>
                        <p class="mt-2.5 grow text-[0.92rem] leading-relaxed text-muted">{{ $course->summary }}</p>

                        <div class="mt-6 flex items-center justify-between border-t border-deep/10 pt-5">
                            <span class="text-[0.8rem] text-muted">{{ $course->format }}</span>
                            <a href="{{ route('community.course', $course) }}"
                                class="inline-flex min-h-6 items-center text-sm font-semibold text-violet">Details &rarr;</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Membership + mentorship ---------------------------------------------- --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-14 px-6 lg:grid-cols-2">
            <div class="reveal">
                <x-eyebrow>Membership</x-eyebrow>
                <h2 class="mt-5 text-[clamp(1.5rem,2.7vw,2.1rem)] text-deep-900">
                    One community, every path to growth.
                </h2>
                <p class="mt-5 leading-relaxed text-muted">
                    GrowSphere is a dynamic community designed to empower individuals on their journey toward personal
                    and financial growth — a hub for like-minded people unlocking their potential through engaging
                    discussions, expert-led workshops and collaborative experiences.
                </p>

                <ul class="mt-8 space-y-3.5">
                    @foreach (['Cohort-based programs every 2 months', 'Premium skill courses with tutorials and resources', 'Scheduled group training sessions', 'One-on-one mentorship for direct guidance', 'Certificates for every completed program', 'Upsells to advanced programs and resources'] as $benefit)
                        <li class="flex items-start gap-3 text-[0.95rem] text-ink">
                            <span
                                class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet text-white">
                                <x-service-icon name="check" class="h-3 w-3" />
                            </span>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>

                <div class="mt-9 flex flex-wrap gap-3">
                    <x-button variant="accent" :href="route('contact', ['type' => 'cohort'])">Book a cohort</x-button>
                    <x-button variant="ghost" :href="route('contact', ['type' => 'mentorship'])">Book mentorship</x-button>
                </div>
            </div>

            <div class="space-y-5">
                <x-substack-embed class="reveal" heading="Join the community newsletter" />

                @if ($testimonials->isNotEmpty())
                    @foreach ($testimonials->take(2) as $testimonial)
                        <figure class="reveal rounded-[var(--radius-brand)] bg-lilac-soft p-7">
                            <blockquote class="text-[0.95rem] leading-relaxed text-ink">“{{ $testimonial->quote }}”</blockquote>
                            <figcaption class="mt-4 text-sm font-semibold text-deep">
                                {{ $testimonial->name }}
                                <span class="font-normal text-muted">
                                    — {{ collect([$testimonial->role, $testimonial->company])->filter()->implode(', ') }}
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    @if ($posts->isNotEmpty())
        <section class="pb-4">
            <div class="mx-auto max-w-6xl px-6">
                <div class="flex flex-wrap items-end justify-between gap-6">
                    <x-section-head eyebrow="From the community" title="Latest notes." />
                    <x-button variant="ghost" :href="route('insights.index')" class="reveal">All insights</x-button>
                </div>

                <div class="mt-12 grid gap-5 sm:grid-cols-2">
                    @foreach ($posts as $post)
                        <a href="{{ route('insights.show', $post) }}"
                            class="reveal group rounded-[var(--radius-brand)] border border-deep/10 bg-white p-7 transition hover:border-violet">
                            <span class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                {{ $post->category }}
                            </span>
                            <h3 class="mt-2.5 font-display text-[1.05rem] text-deep-900 group-hover:text-violet">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                {{ \Illuminate\Support\Str::limit($post->excerpt, 130) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta title="Wait for a cohort, or get one-on-one mentorship."
        body="Cohorts run once every two months. If you need direct guidance sooner, book a personalised mentorship session." />
</x-layouts.site>
