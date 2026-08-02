@props([
    'title' => 'Ready to put your brand at the centre of its market?',
    'body' => "Tell us about your project or join the next cohort. We'll reply within 24 hours.",
])

<section class="mt-20 lg:mt-24">
    <div class="mx-auto max-w-6xl px-6">
        <div
            class="reveal relative overflow-hidden rounded-[28px] bg-gradient-to-br from-deep to-deep-900 px-8 py-16 text-center text-white sm:px-14">
            <div class="pointer-events-none absolute inset-0 brand-pattern"></div>
            <div
                class="pointer-events-none absolute -top-40 -right-32 h-[420px] w-[420px] rounded-full border border-white/15"></div>
            <div
                class="pointer-events-none absolute -top-20 -right-14 h-[260px] w-[260px] rounded-full border border-dashed border-white/20"></div>

            <div class="relative">
                <h2 class="mx-auto max-w-2xl text-[clamp(1.5rem,3vw,2.2rem)]">{{ $title }}</h2>
                <p class="mx-auto mt-4 max-w-lg leading-relaxed text-lilac/80">{{ $body }}</p>

                <div class="mt-9 flex flex-wrap justify-center gap-3">
                    <x-button variant="light" :href="route('contact')">Start a project</x-button>
                    <x-button variant="outline-light" :href="route('community.index')">Join our community</x-button>
                </div>
            </div>
        </div>
    </div>
</section>
