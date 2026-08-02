@php $editing = $post->exists; @endphp

<x-admin.layout :title="$editing ? 'Edit post' : 'New post'">
    <x-slot:subtitle>{{ $editing ? $post->title : 'Publish an insight or announcement.' }}</x-slot:subtitle>

    <form method="POST" action="{{ $editing ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
        enctype="multipart/form-data" class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <x-admin.panel title="Content">
                <div class="space-y-5">
                    <x-admin.field label="Title" name="title" :value="$post->title" required slug-source="#field-slug" />
                    <x-admin.field label="Excerpt" name="excerpt" type="textarea" rows="3" :value="$post->excerpt"
                        help="Shown on cards and as the lead paragraph." />
                    <x-admin.field label="Body" name="body" type="textarea" rows="16" :value="$post->body"
                        help="Separate paragraphs with a blank line." />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Cover image">
                <x-admin.image-field label="Cover" name="cover" :current="$post->cover" help="Optional. Max 5 MB." />
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            <x-admin.panel title="Publishing">
                <div class="space-y-5">
                    <x-admin.field label="Category" name="category" :value="$post->category" required
                        placeholder="Insight" />
                    <x-admin.field label="Author" name="author" :value="$post->author" />
                    <x-admin.field label="Publish date" name="published_at" type="date" :value="$post->published_at?->format('Y-m-d')"
                        help="Leave blank and tick Published to publish now." />
                    <x-admin.field label="Slug" name="slug" :value="$post->slug" placeholder="auto-generated" />
                    <x-admin.toggle label="Published" name="is_published" :checked="$post->is_published ?? false"
                        help="Drafts stay hidden from the public site." />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Also on Substack"
                description="Posts published here don't sync to Substack automatically — publish there too if you want it in the newsletter.">
                @if (\App\Models\Setting::get('substack_url'))
                    <a href="{{ \App\Models\Setting::get('substack_url') }}" target="_blank" rel="noopener"
                        class="text-sm font-semibold text-violet">Open Substack &rarr;</a>
                @else
                    <a href="{{ route('admin.settings.edit') }}" class="text-sm font-semibold text-violet">
                        Add your Substack URL in settings &rarr;
                    </a>
                @endif
            </x-admin.panel>

            <div class="flex flex-wrap gap-3">
                <x-button variant="accent" type="submit">{{ $editing ? 'Save changes' : 'Create post' }}</x-button>
                <x-button variant="ghost" :href="route('admin.posts.index')">Cancel</x-button>
            </div>
        </div>
    </form>
</x-admin.layout>
