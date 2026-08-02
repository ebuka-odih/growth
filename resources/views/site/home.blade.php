@php
    use App\Models\Setting;

    $heading = Setting::get('hero_heading', 'We build brands that grow beyond their market.');
    $highlight = Setting::get('hero_highlight');
    $headingHtml = e($heading);

    if ($highlight && str_contains($heading, $highlight)) {
        $headingHtml = str_replace(
            e($highlight),
            '<span class="relative whitespace-nowrap text-violet">' .
                e($highlight) .
                '<span class="absolute inset-x-0 -bottom-1 -z-10 h-3 rounded bg-violet/20"></span></span>',
            $headingHtml,
        );
    }

    $stats = [
        [Setting::get('stat_one_value'), Setting::get('stat_one_label')],
        [Setting::get('stat_two_value'), Setting::get('stat_two_label')],
        [Setting::get('stat_three_value'), Setting::get('stat_three_label')],
    ];

    $process = [
        ['Discover', 'We learn your business, audience and goals through a strategic consultation.'],
        ['Design', 'Identity, web development, product or campaign creative — crafted to position you strongly.'],
        ['Launch', 'We ship across channels: web, social, print, motion and ads.'],
        ['Grow', 'Performance tracking, optimisation and ongoing growth strategy.'],
    ];
@endphp

<x-layouts.site>
    {{-- Hero ---------------------------------------------------------------- --}}
    <section class="relative overflow-hidden pt-20 pb-24 lg:pt-24 lg:pb-28">
        <div class="pointer-events-none absolute inset-0 brand-pattern-ink opacity-70"></div>

        <div class="relative mx-auto grid max-w-6xl items-center gap-14 px-6 lg:grid-cols-[1.15fr_0.85fr]">
            <div>
                <x-eyebrow>{{ Setting::get('site_tagline') }}</x-eyebrow>

                <h1 class="mt-6 text-[clamp(2.1rem,4.6vw,3.7rem)] text-deep-900">{!! $headingHtml !!}</h1>

                <p class="mt-6 max-w-xl text-[1.08rem] leading-relaxed text-muted">
                    {{ Setting::get('hero_subheading') }}
                </p>

                <div class="mt-9 flex flex-wrap gap-3">
                    <x-button variant="accent" :href="route('contact')">Start a project</x-button>
                    <x-button variant="ghost" :href="route('community.index')">Join the community</x-button>
                </div>

                <dl class="mt-14 flex flex-wrap gap-x-12 gap-y-6">
                    @foreach ($stats as [$value, $label])
                        @if ($value)
                            <div>
                                <dt class="font-display text-2xl text-deep">{{ $value }}</dt>
                                <dd class="mt-1 text-sm text-muted">{{ $label }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>

            {{-- Orbit: the brand's "growing within your sphere" idea, made literal. --}}
            <div class="orbit relative mx-auto aspect-square w-full max-w-[420px]">
                {{-- Only the dashed ring is animated; spinning a solid circle reads as nothing. --}}
                <div class="absolute inset-0 rounded-full border border-deep/15"></div>
                <div class="absolute inset-[12%] rounded-full border border-deep/25"></div>
                <div class="animate-spin-slower absolute inset-[26%] rounded-full border border-dashed border-deep/25"></div>

                <div class="orbit-pulse absolute inset-[34%] rounded-full bg-violet/25"></div>

                <div
                    class="absolute inset-[37%] flex items-center justify-center rounded-full bg-deep p-4 text-center font-display text-[0.78rem] leading-tight text-white shadow-[0_24px_60px_rgba(51,0,102,0.4)]">
                    Your brand at the centre
                </div>

                {{-- Satellites ride this ring; each label counter-rotates so it stays readable. --}}
                <div class="orbit-track">
                    @foreach ($services->take(4) as $i => $service)
                        <div class="orbit-node" style="--orbit-angle: {{ $i * 90 }}deg">
                            <div class="orbit-anchor">
                                <div class="orbit-counter">
                                    <div class="orbit-upright" style="--orbit-angle: {{ $i * 90 }}deg">
                                        <span
                                            class="orbit-pill rounded-full border border-deep/10 bg-white px-4 py-2 text-[0.7rem] font-semibold text-deep shadow-[0_10px_24px_rgba(22,9,31,0.09)]">
                                            {{ \Illuminate\Support\Str::words(\Illuminate\Support\Str::before($service->title, ' &'), 2, '') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Services ------------------------------------------------------------ --}}
    <section id="services" class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="What we do" title="Every layer of your growth, under one sphere.">
                Full-service branding, design, technology and marketing — built to position your business strongly and
                keep it growing.
            </x-section-head>

            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service) }}"
                        class="reveal group flex flex-col gap-3 rounded-[var(--radius-brand)] border border-deep/10 bg-white p-7 transition duration-300 hover:-translate-y-1.5 hover:border-violet hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                        <span
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-lilac text-deep transition group-hover:bg-violet group-hover:text-white">
                            <x-service-icon :name="$service->icon" />
                        </span>
                        <h3 class="text-[1rem] font-semibold text-deep-900">{{ $service->title }}</h3>
                        <p class="text-sm leading-relaxed text-muted">{{ $service->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Work ---------------------------------------------------------------- --}}
    <section class="relative overflow-hidden bg-deep-900 py-20 text-white lg:py-24">
        <div class="pointer-events-none absolute inset-0 brand-pattern"></div>

        <div class="relative mx-auto max-w-6xl px-6">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-head eyebrow="Selected work" title="Projects that moved brands forward." tone="light">
                    A snapshot of identity, web development and campaign work.
                </x-section-head>
                <x-button variant="outline-light" :href="route('work.index')" class="reveal">View all work</x-button>
            </div>

            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <a href="{{ route('work.show', $project) }}"
                        class="reveal group overflow-hidden rounded-[var(--radius-brand)] border border-white/10 bg-deep-700 transition duration-300 hover:-translate-y-1.5">
                        @if ($project->imageUrl())
                            <img src="{{ $project->imageUrl() }}" alt="{{ $project->title }}"
                                class="h-56 w-full object-cover" loading="lazy">
                        @else
                            <x-placeholder tone="dark" label="Project image" class="min-h-56 border-0" />
                        @endif
                        <div class="p-6">
                            <h3 class="text-[0.98rem] font-semibold text-white">{{ $project->title }}</h3>
                            <p class="mt-1.5 text-[0.82rem] text-lilac/60">{{ $project->disciplines }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Community ----------------------------------------------------------- --}}
    <section id="community" class="bg-lilac-soft py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="GrowSphere Community" title="Learn & grow with our cohorts.">
                Structured 3-week training programs, premium skill courses and one-on-one mentorship — with certificates
                at every stage. {{ Setting::get('cohort_cadence') }}
            </x-section-head>

            <div class="mt-14 grid items-start gap-14 lg:grid-cols-2">
                <div>
                    @foreach ($cohorts as $cohort)
                        <div class="reveal relative grid grid-cols-[56px_1fr] gap-5 py-6">
                            @unless ($loop->last)
                                <span class="absolute top-[84px] bottom-0 left-[27px] w-0.5 bg-deep/20"></span>
                            @endunless

                            <span
                                class="z-10 flex h-14 w-14 items-center justify-center rounded-full border-2 border-deep bg-white font-display text-sm text-deep">
                                {{ $cohort->code ?: '·' }}
                            </span>

                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-[1.05rem] font-semibold text-deep-900">
                                        <a href="{{ route('community.cohort', $cohort) }}" class="hover:text-violet">
                                            {{ $cohort->title }}
                                        </a>
                                    </h3>
                                    <span
                                        class="rounded-full px-3 py-0.5 text-[0.68rem] font-semibold {{ $cohort->status === 'open' ? 'bg-violet text-white' : 'bg-white text-deep border border-deep/10' }}">
                                        {{ $cohort->statusLabel() }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm leading-relaxed text-muted">
                                    {{ $cohort->tagline ?: \Illuminate\Support\Str::limit($cohort->description, 150) }}
                                </p>
                                <span
                                    class="mt-3 inline-block rounded-full border border-deep/10 bg-white px-3.5 py-1 text-[0.7rem] font-semibold text-deep">
                                    {{ $cohort->duration }}@if ($cohort->has_certificate) · Certificate @endif
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <div class="reveal relative grid grid-cols-[56px_1fr] gap-5 py-6">
                        <span
                            class="z-10 flex h-14 w-14 items-center justify-center rounded-full border-2 border-dashed border-deep bg-white font-display text-lg text-deep">+</span>
                        <div>
                            <h3 class="text-[1.05rem] font-semibold text-deep-900">Skill courses &amp; group trainings</h3>
                            <p class="mt-2 text-sm leading-relaxed text-muted">
                                Graphic design, motion design and website design courses with tutorials, resources and
                                advanced tiers.
                            </p>
                            <a href="{{ route('community.index') }}#courses"
                                class="mt-3 inline-flex min-h-6 items-center text-sm font-semibold text-violet underline underline-offset-4">
                                Browse courses
                            </a>
                        </div>
                    </div>
                </div>

                <aside
                    class="reveal rounded-[var(--radius-brand)] bg-white p-9 shadow-[0_24px_60px_rgba(51,0,102,0.12)] lg:sticky lg:top-28">
                    <x-eyebrow>Membership</x-eyebrow>
                    <h3 class="mt-4 text-xl text-deep-900">One community, every path to growth.</h3>

                    <ul class="mt-6 space-y-3.5">
                        @foreach (['Cohort-based programs every 3 months', 'Premium skill courses with resources', 'One-on-one mentorship sessions', 'Certificates for every completed program', 'Upsells to advanced programs'] as $benefit)
                            <li class="flex items-start gap-3 text-[0.92rem] text-ink">
                                <span
                                    class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet text-white">
                                    <x-service-icon name="check" class="h-3 w-3" />
                                </span>
                                {{ $benefit }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8 space-y-3">
                        <x-button variant="primary" :href="route('contact', ['type' => 'cohort'])" class="w-full">Book a cohort</x-button>
                        <x-button variant="ghost" :href="route('contact', ['type' => 'mentorship'])" class="w-full">
                            Book 1-on-1 mentorship
                        </x-button>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Process ------------------------------------------------------------- --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="How we work" title="From discovery to growth, in four moves." />

            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($process as $i => [$title, $copy])
                    <div class="reveal rounded-[var(--radius-brand)] border border-deep/10 bg-white p-7">
                        <span class="text-[0.72rem] font-semibold tracking-[0.14em] text-violet uppercase">
                            Step {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <h3 class="mt-3 text-[1rem] font-semibold text-deep-900">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --------------------------------------------------------- --}}
    @if ($testimonials->isNotEmpty())
        <section class="bg-lilac-soft py-20 lg:py-24">
            <div class="mx-auto max-w-6xl px-6">
                <x-section-head eyebrow="In their words" title="What working with us feels like." />

                <div class="mt-14 grid gap-5 md:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <figure class="reveal flex h-full flex-col rounded-[var(--radius-brand)] bg-white p-8">
                            <x-mark class="h-6 w-6 text-violet" />
                            <blockquote class="mt-5 grow text-[0.95rem] leading-relaxed text-ink">
                                “{{ $testimonial->quote }}”
                            </blockquote>
                            <figcaption class="mt-6 flex items-center gap-3 border-t border-deep/10 pt-5">
                                @if ($testimonial->avatarUrl())
                                    <img src="{{ $testimonial->avatarUrl() }}" alt=""
                                        class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-lilac font-display text-xs text-deep">
                                        {{ $testimonial->initials() }}
                                    </span>
                                @endif
                                <span>
                                    <span class="block text-sm font-semibold text-deep-900">{{ $testimonial->name }}</span>
                                    <span class="block text-xs text-muted">
                                        {{ collect([$testimonial->role, $testimonial->company])->filter()->implode(' · ') }}
                                    </span>
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Insights + Substack --------------------------------------------------- --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-head eyebrow="Insights" title="Notes on brand, growth and money.">
                    Published on the site and to the GrowSphere Community newsletter.
                </x-section-head>
                <x-button variant="ghost" :href="route('insights.index')" class="reveal">All insights</x-button>
            </div>

            <div class="mt-14 grid gap-10 lg:grid-cols-[1.35fr_1fr]">
                <div class="grid gap-4">
                    @forelse ($posts as $post)
                        <a href="{{ route('insights.show', $post) }}"
                            class="reveal group flex items-start gap-5 rounded-[var(--radius-brand)] border border-deep/10 bg-white p-6 transition hover:border-violet">
                            <span
                                class="hidden h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-lilac text-deep sm:flex">
                                <x-mark class="h-7 w-7" />
                            </span>
                            <span class="min-w-0">
                                <span class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                    {{ $post->category }}
                                </span>
                                <span class="mt-2 block font-display text-[1.05rem] text-deep-900 group-hover:text-violet">
                                    {{ $post->title }}
                                </span>
                                <span class="mt-2 block text-sm leading-relaxed text-muted">
                                    {{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}
                                </span>
                            </span>
                        </a>
                    @empty
                        <p class="text-sm text-muted">No posts published yet.</p>
                    @endforelse
                </div>

                <x-substack-embed class="reveal" />
            </div>
        </div>
    </section>

    {{-- About + CTA ----------------------------------------------------------- --}}
    <section class="pb-6">
        <div class="mx-auto grid max-w-6xl items-center gap-14 px-6 lg:grid-cols-2">
            <div class="reveal overflow-hidden rounded-[var(--radius-brand)]">
                <img src="{{ asset('images/brand/mockup-1.jpg') }}" alt="GrowSphere brand applied across touchpoints"
                    class="h-full w-full object-cover" loading="lazy">
            </div>

            <div class="reveal">
                <x-eyebrow>About GrowSphere</x-eyebrow>
                <h2 class="mt-5 text-[clamp(1.5rem,2.7vw,2.1rem)] text-deep-900">
                    More than an agency — a growth ecosystem.
                </h2>
                <p class="mt-5 leading-relaxed text-muted">{{ Setting::get('mission') }}</p>
                <p class="mt-4 leading-relaxed text-muted">{{ Setting::get('vision') }}</p>

                <div class="mt-8 flex flex-wrap gap-x-10 gap-y-5">
                    @foreach (['Innovation', 'Integrity', 'Excellence'] as $value)
                        <div>
                            <span class="block font-display text-[1.1rem] text-deep">{{ $value }}</span>
                            <span class="text-xs text-muted">Core value</span>
                        </div>
                    @endforeach
                </div>

                <x-button variant="ghost" :href="route('about')" class="mt-8">Read our story</x-button>
            </div>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
