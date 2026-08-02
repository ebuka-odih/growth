<x-layouts.site title="Insights" description="Notes on brand, growth and money from GrowSphere Solutions and the GrowSphere Community.">
    <x-page-header eyebrow="Insights" title="Notes on brand, growth and money.">
        Announcements, playbooks and thinking from the GrowSphere team — also published to our Substack.
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-14 lg:grid-cols-[1.5fr_1fr]">
                <div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        @forelse ($posts as $post)
                            <a href="{{ route('insights.show', $post) }}"
                                class="reveal group flex flex-col overflow-hidden rounded-[var(--radius-brand)] border border-deep/10 bg-white transition hover:-translate-y-1.5 hover:border-violet hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                                @if ($post->coverUrl())
                                    <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}"
                                        class="h-44 w-full object-cover" loading="lazy">
                                @endif

                                <div class="flex grow flex-col p-7">
                                    <div class="flex items-center gap-3 text-[0.68rem] font-semibold uppercase">
                                        <span class="tracking-[0.16em] text-violet">{{ $post->category }}</span>
                                        <span class="text-muted">{{ $post->published_at?->format('j M Y') }}</span>
                                    </div>

                                    <h2 class="mt-3 font-display text-[1.1rem] text-deep-900 group-hover:text-violet">
                                        {{ $post->title }}
                                    </h2>
                                    <p class="mt-2.5 grow text-[0.92rem] leading-relaxed text-muted">
                                        {{ \Illuminate\Support\Str::limit($post->excerpt, 140) }}
                                    </p>
                                    <span class="mt-5 text-xs text-muted">{{ $post->readingTime() }} min read</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-muted">No insights published yet.</p>
                        @endforelse
                    </div>

                    @if ($posts->hasPages())
                        <div class="mt-12">{{ $posts->links() }}</div>
                    @endif
                </div>

                <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                    <x-substack-embed class="reveal" heading="Subscribe on Substack" />
                </aside>
            </div>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
