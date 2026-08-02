<x-layouts.site title="Services" description="Full-service branding, design, technology and marketing from GrowSphere Solutions.">
    <x-page-header eyebrow="What we do" title="Every layer of your growth, under one sphere.">
        We provide strategic branding, business consultancy, logo design, motion graphics, graphic design, website
        development, product design, marketing and creative media solutions that help businesses establish a strong
        market position.
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service) }}"
                        class="reveal group flex flex-col rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8 transition duration-300 hover:-translate-y-1.5 hover:border-violet hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-lilac text-deep transition group-hover:bg-violet group-hover:text-white">
                            <x-service-icon :name="$service->icon" class="h-5 w-5" />
                        </span>

                        <h2 class="mt-5 text-[1.15rem] font-semibold text-deep-900">{{ $service->title }}</h2>
                        <p class="mt-2.5 text-[0.94rem] leading-relaxed text-muted">{{ $service->excerpt }}</p>

                        @if ($service->deliverableList())
                            <ul class="mt-5 flex flex-wrap gap-2">
                                @foreach (array_slice($service->deliverableList(), 0, 4) as $item)
                                    <li
                                        class="rounded-full border border-deep/10 bg-lilac-soft px-3 py-1 text-[0.7rem] font-medium text-deep">
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <span class="mt-6 inline-flex min-h-6 items-center text-sm font-semibold text-violet">Explore this service &rarr;</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
