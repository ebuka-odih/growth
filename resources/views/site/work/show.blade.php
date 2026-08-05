<x-layouts.site :title="$project->title" :description="$project->summary">
    <x-page-header :eyebrow="$project->category ?: 'Project'" :title="$project->title" :back="route('work.index')" back-label="All work">
        {{ $project->summary }}
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <x-media-gallery class="reveal" :media="$project->orderedMedia()" :video-url="$project->video_url"
                :title="$project->title" placeholder="Project image" />

            <div class="mt-14 grid gap-14 lg:grid-cols-[1.4fr_1fr]">
                <div class="reveal prose-brand">
                    @forelse (preg_split('/\r\n\r\n|\n\n/', (string) $project->body) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @empty
                    @endforelse

                    @if (blank($project->body))
                        <p>{{ $project->summary }}</p>
                    @endif
                </div>

                <aside class="reveal">
                    <dl class="rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                        @foreach (['Client' => $project->client, 'Category' => $project->category, 'Disciplines' => $project->disciplines, 'Year' => $project->year] as $label => $value)
                            @if ($value)
                                <div class="border-b border-deep/8 py-3 first:pt-0 last:border-0 last:pb-0">
                                    <dt class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                        {{ $label }}
                                    </dt>
                                    <dd class="mt-1 text-[0.94rem] text-ink">{{ $value }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>

                    @if ($project->website_url)
                        <x-button variant="ghost" :href="$project->website_url" target="_blank" rel="noopener noreferrer"
                            class="mt-5 w-full">
                            Visit {{ $project->websiteHost() }}
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                class="h-3.5 w-3.5 shrink-0" aria-hidden="true">
                                <path d="M7 17 17 7M9 7h8v8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </x-button>
                    @endif

                    <x-button variant="primary" :href="route('contact')" class="mt-5 w-full">Start a project like this</x-button>
                </aside>
            </div>

            @if ($more->isNotEmpty())
                <div class="mt-20">
                    <h2 class="text-xl text-deep-900">More work</h2>
                    <div class="mt-7 grid gap-5 sm:grid-cols-3">
                        @foreach ($more as $other)
                            <a href="{{ route('work.show', $other) }}"
                                class="reveal group overflow-hidden rounded-[var(--radius-brand)] border border-deep/10 bg-white transition hover:border-violet">
                                @if ($other->imageUrl())
                                    <img src="{{ $other->imageUrl() }}" alt="{{ $other->title }}"
                                        class="h-40 w-full object-cover" loading="lazy">
                                @else
                                    <x-placeholder label="Project" class="min-h-40 border-0" />
                                @endif
                                <div class="p-5">
                                    <h3 class="text-[0.94rem] font-semibold text-deep-900 group-hover:text-violet">
                                        {{ $other->title }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <x-cta />
</x-layouts.site>
