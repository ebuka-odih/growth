<x-layouts.site :title="$course->title" :description="$course->summary">
    <x-page-header :eyebrow="$course->category ?: 'Skill course'" :title="$course->title" :back="route('community.index') . '#courses'"
        back-label="All courses">
        {{ $course->summary }}

        <x-slot:actions>
            <x-button variant="light" :href="route('contact', ['type' => 'course', 'course' => $course->id])">
                Enrol in this course
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto grid max-w-6xl gap-14 px-6 lg:grid-cols-[1.4fr_1fr]">
            <div class="reveal">
                @if ($course->imageUrl())
                    <img src="{{ $course->imageUrl() }}" alt="{{ $course->title }}"
                        class="mb-10 w-full rounded-[var(--radius-brand)] object-cover">
                @endif

                <div class="prose-brand">
                    @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $course->description) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>

                @if ($course->outcomeList())
                    <h2 class="mt-12 text-xl text-deep-900">What you'll learn</h2>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ($course->outcomeList() as $outcome)
                            <li
                                class="flex items-start gap-3 rounded-xl border border-deep/10 bg-white px-4 py-3.5 text-[0.92rem]">
                                <span
                                    class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet text-white">
                                    <x-service-icon name="check" class="h-3 w-3" />
                                </span>
                                {{ $outcome }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <aside class="reveal space-y-5">
                <div class="rounded-[var(--radius-brand)] bg-deep p-8 text-white">
                    <x-eyebrow tone="light">{{ $course->level }}</x-eyebrow>
                    <h3 class="mt-4 text-lg">{{ $course->format }}</h3>
                    @if ($course->price)
                        <p class="mt-4 font-display text-2xl">₦{{ number_format((float) $course->price) }}</p>
                    @endif
                    <p class="mt-3 text-sm leading-relaxed text-lilac/75">
                        Includes tutorials and downloadable resources. Advanced tiers available when you're ready.
                    </p>
                    <x-button variant="light" :href="route('contact', ['type' => 'course', 'course' => $course->id])"
                        class="mt-6 w-full">Enrol now</x-button>
                </div>

                @if ($others->isNotEmpty())
                    <div class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                        <h3 class="text-[1rem] font-semibold text-deep-900">Other courses</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($others as $other)
                                <li>
                                    <a href="{{ route('community.course', $other) }}"
                                        class="block py-1 text-[0.92rem] text-ink hover:text-violet">
                                        {{ $other->title }}
                                        <span class="block text-xs text-muted">{{ $other->level }}</span>
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
