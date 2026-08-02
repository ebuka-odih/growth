<x-layouts.site :title="$service->title" :description="$service->excerpt">
    <x-page-header eyebrow="Service" :title="$service->title" :back="route('services.index')" back-label="All services">
        {{ $service->excerpt }}

        <x-slot:actions>
            <x-button variant="light" :href="route('contact', ['subject' => $service->title])">Start a project</x-button>
            <x-button variant="outline-light" :href="route('work.index')">See related work</x-button>
        </x-slot:actions>
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-14 px-6 lg:grid-cols-[1.4fr_1fr]">
            <div class="reveal">
                <div class="prose-brand">
                    @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $service->description) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>

                @if ($service->deliverableList())
                    <h2 class="mt-12 text-xl text-deep-900">What's included</h2>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ($service->deliverableList() as $item)
                            <li
                                class="flex items-start gap-3 rounded-xl border border-deep/10 bg-white px-4 py-3.5 text-[0.92rem]">
                                <span
                                    class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet text-white">
                                    <x-service-icon name="check" class="h-3 w-3" />
                                </span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <aside class="reveal space-y-5">
                <div class="rounded-[var(--radius-brand)] bg-deep p-8 text-white">
                    <x-eyebrow tone="light">Next step</x-eyebrow>
                    <h3 class="mt-4 text-lg">Book a strategic consultation.</h3>
                    <p class="mt-3 text-sm leading-relaxed text-lilac/75">
                        We start every engagement by understanding your business, audience and goals — then scope the
                        work around them.
                    </p>
                    <x-button variant="light" :href="route('contact', ['subject' => $service->title])" class="mt-6 w-full">
                        Enquire about {{ \Illuminate\Support\Str::limit($service->title, 22) }}
                    </x-button>
                </div>

                @if ($others->isNotEmpty())
                    <div class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                        <h3 class="text-[1rem] font-semibold text-deep-900">Other services</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($others as $other)
                                <li>
                                    <a href="{{ route('services.show', $other) }}"
                                        class="flex min-h-6 items-center gap-3 py-1 text-[0.92rem] text-ink hover:text-violet">
                                        <x-service-icon :name="$other->icon" class="h-4 w-4 shrink-0 text-violet" />
                                        {{ $other->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
