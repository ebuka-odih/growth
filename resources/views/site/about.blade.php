@php use App\Models\Setting; @endphp

<x-layouts.site title="About" :description="Setting::get('mission')">
    <x-page-header eyebrow="About GrowSphere" title="More than an agency — a growth ecosystem.">
        GrowSphere Solutions Limited is a growth-focused company committed to solving digital challenges for
        individuals, entrepreneurs, startups, SMEs and organisations — helping them build an impactful brand, improve
        business performance and achieve sustainable growth.
    </x-page-header>

    {{-- Mission / vision ------------------------------------------------------ --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-5 px-6 md:grid-cols-2">
            <div class="reveal rounded-[var(--radius-brand)] border border-deep/10 bg-white p-9">
                <x-eyebrow>Our mission</x-eyebrow>
                <p class="mt-5 text-[1.05rem] leading-relaxed text-ink">{{ Setting::get('mission') }}</p>
            </div>
            <div class="reveal rounded-[var(--radius-brand)] bg-deep p-9 text-white">
                <x-eyebrow tone="light">Our vision</x-eyebrow>
                <p class="mt-5 text-[1.05rem] leading-relaxed text-lilac/85">{{ Setting::get('vision') }}</p>
            </div>
        </div>
    </section>

    {{-- The name -------------------------------------------------------------- --}}
    <section class="relative overflow-hidden bg-deep-900 py-20 text-white lg:py-24">
        <div class="pointer-events-none absolute inset-0 brand-pattern"></div>

        <div class="relative mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="The name" title="Carved from GROW and SPHERE." tone="light">
                Two words that describe how we think growth actually works.
            </x-section-head>

            <div class="mt-14 grid gap-5 md:grid-cols-3">
                @foreach ([['Grow', 'To increase in magnitude. GROW signifies progress, learning and transformation — our commitment to helping individuals unlock their potential, gain new skills and achieve their goals.'], ['Sphere', 'The region in which something or someone is active. A perfectly symmetrical shape representing balance and unity — a closed, connected space.'], ['Spiral growth', 'The mark connotes growing within your own sphere: personal and financial growth nurtured in harmony, inside a tight-knit and supportive community.']] as [$term, $copy])
                    <div class="reveal rounded-[var(--radius-brand)] border border-white/10 bg-deep-700/60 p-8">
                        <x-mark class="h-8 w-8 text-violet" />
                        <h3 class="mt-5 text-[1.15rem] text-white">{{ $term }}</h3>
                        <p class="mt-3 text-[0.92rem] leading-relaxed text-lilac/70">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Founder --------------------------------------------------------------- --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl items-center gap-14 px-6 lg:grid-cols-[0.85fr_1.15fr]">
            <div class="reveal relative mx-auto w-full max-w-sm lg:mx-0">
                <div class="absolute -top-4 -left-4 h-24 w-24 rounded-full border-2 border-violet/25"></div>
                <img src="{{ asset('images/helen.png') }}"
                    alt="{{ Setting::get('founder_name') }}, {{ Setting::get('founder_role') }}"
                    class="relative aspect-4/5 w-full rounded-[var(--radius-brand)] object-cover object-top shadow-[0_24px_60px_rgba(51,0,102,0.18)]"
                    width="1122" height="1402" loading="lazy">
            </div>

            <div class="reveal">
                <x-eyebrow>Personality behind the brand</x-eyebrow>
                <h2 class="mt-5 text-[clamp(1.5rem,2.7vw,2.1rem)] text-deep-900">
                    {{ Setting::get('founder_name') }}
                </h2>
                <p class="mt-2 text-sm font-semibold tracking-wide text-violet">{{ Setting::get('founder_role') }}</p>
                <p class="mt-5 leading-relaxed text-muted">{{ Setting::get('founder_bio') }}</p>
                <p class="mt-4 leading-relaxed text-muted">{{ Setting::get('community_mission') }}</p>
            </div>
        </div>
    </section>

    {{-- Values ---------------------------------------------------------------- --}}
    <section class="bg-lilac-soft py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-section-head eyebrow="Core values" title="What we hold ourselves to." />

            <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([['Innovation', 'New thinking applied to real business problems.'], ['Professionalism', 'Clear process, clear communication, delivered on time.'], ['Excellence', 'Work that holds up against anything in the market.'], ['Integrity', 'Honest scoping, honest reporting, honest advice.'], ['Creativity', 'Ideas that make brands impossible to ignore.'], ['Growth', 'Every decision measured against whether it grows the business.']] as [$value, $copy])
                    <div class="reveal rounded-[var(--radius-brand)] bg-white p-7">
                        <h3 class="font-display text-[1.05rem] text-deep">{{ $value }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services recap --------------------------------------------------------- --}}
    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-head eyebrow="What we deliver" title="Eight service lines, one team." />
                <x-button variant="ghost" :href="route('services.index')" class="reveal">All services</x-button>
            </div>

            <div class="mt-12 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service) }}"
                        class="reveal flex items-center gap-3 rounded-xl border border-deep/10 bg-white px-5 py-4 text-[0.9rem] text-ink transition hover:border-violet hover:text-violet">
                        <x-service-icon :name="$service->icon" class="h-4 w-4 shrink-0 text-violet" />
                        {{ $service->title }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
