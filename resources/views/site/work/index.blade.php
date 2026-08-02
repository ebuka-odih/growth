<x-layouts.site title="Work" description="Identity, web, product, motion and campaign work from GrowSphere Solutions.">
    <x-page-header eyebrow="Selected work" title="Projects that moved brands forward.">
        A snapshot of identity, web and campaign work across startups, SMEs and personal brands.
    </x-page-header>

    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-6xl px-6">
            @if ($categories->isNotEmpty())
                <div class="mb-12 flex flex-wrap gap-2.5">
                    <a href="{{ route('work.index') }}"
                        class="inline-flex min-h-6 items-center rounded-full border px-4 py-2 text-[0.82rem] font-semibold transition {{ !$category ? 'border-deep bg-deep text-white' : 'border-deep/15 bg-white text-deep hover:border-violet' }}">
                        All
                    </a>
                    @foreach ($categories as $item)
                        <a href="{{ route('work.index', ['category' => $item]) }}"
                            class="inline-flex min-h-6 items-center rounded-full border px-4 py-2 text-[0.82rem] font-semibold transition {{ $category === $item ? 'border-deep bg-deep text-white' : 'border-deep/15 bg-white text-deep hover:border-violet' }}">
                            {{ $item }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($projects as $project)
                    <a href="{{ route('work.show', $project) }}"
                        class="reveal group overflow-hidden rounded-[var(--radius-brand)] border border-deep/10 bg-white transition duration-300 hover:-translate-y-1.5 hover:border-violet hover:shadow-[0_22px_44px_rgba(51,0,102,0.12)]">
                        @if ($project->imageUrl())
                            <img src="{{ $project->imageUrl() }}" alt="{{ $project->title }}"
                                class="h-56 w-full object-cover" loading="lazy">
                        @else
                            <x-placeholder label="Project image" class="min-h-56 border-0" />
                        @endif

                        <div class="p-6">
                            @if ($project->category)
                                <span class="text-[0.68rem] font-semibold tracking-[0.16em] text-violet uppercase">
                                    {{ $project->category }}
                                </span>
                            @endif
                            <h2 class="mt-2 text-[1rem] font-semibold text-deep-900 group-hover:text-violet">
                                {{ $project->title }}
                            </h2>
                            <p class="mt-1.5 text-[0.82rem] text-muted">{{ $project->disciplines }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-muted">No projects in this category yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <x-cta />
</x-layouts.site>
