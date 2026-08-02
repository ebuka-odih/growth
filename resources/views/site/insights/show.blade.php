<x-layouts.site :title="$post->title" :description="$post->excerpt">
    <x-page-header :eyebrow="$post->category" :title="$post->title" :back="route('insights.index')" back-label="All insights">
        <span class="text-sm">
            {{ $post->author }}
            @if ($post->published_at)
                · {{ $post->published_at->format('j F Y') }}
            @endif
            · {{ $post->readingTime() }} min read
        </span>
    </x-page-header>

    <article class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            @if ($post->coverUrl())
                <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}"
                    class="reveal mb-14 w-full rounded-[var(--radius-brand)] object-cover">
            @endif

            <div class="grid gap-14 lg:grid-cols-[1.5fr_1fr]">
                <div class="reveal">
                    @if ($post->excerpt)
                        <p class="mb-8 border-l-4 border-violet pl-5 text-[1.15rem] leading-relaxed text-deep">
                            {{ $post->excerpt }}
                        </p>
                    @endif

                    <div class="prose-brand">
                        @foreach (preg_split('/\r\n\r\n|\n\n/', (string) $post->body) as $paragraph)
                            @if (trim($paragraph))
                                <p>{{ trim($paragraph) }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>

                <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                    <x-substack-embed class="reveal" heading="Never miss a post" />

                    @if ($more->isNotEmpty())
                        <div class="reveal rounded-[var(--radius-brand)] border border-deep/10 bg-white p-8">
                            <h2 class="text-[1rem] font-semibold text-deep-900">Keep reading</h2>
                            <ul class="mt-4 space-y-4">
                                @foreach ($more as $other)
                                    <li>
                                        <a href="{{ route('insights.show', $other) }}" class="group block py-1">
                                            <span class="text-[0.66rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                                {{ $other->category }}
                                            </span>
                                            <span class="mt-1 block text-[0.92rem] text-ink group-hover:text-violet">
                                                {{ $other->title }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </article>

    <x-cta />
</x-layouts.site>
