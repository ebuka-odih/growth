<x-admin.layout title="Insights">
    <x-slot:subtitle>Posts, announcements and playbooks published to the site.</x-slot:subtitle>
    <x-slot:actions>
        <x-button variant="accent" :href="route('admin.posts.create')" class="!px-5 !py-2.5">Add post</x-button>
    </x-slot:actions>

    @if ($posts->isEmpty())
        <x-admin.empty message="No posts yet.">
            <x-button variant="accent" :href="route('admin.posts.create')">Write the first post</x-button>
        </x-admin.empty>
    @else
        <x-admin.table :headers="['Post', 'Category', 'Author', 'Published', 'Status', 'Actions']">
            @foreach ($posts as $post)
                <tr>
                    <td data-label="Post" data-card-title class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if ($post->coverUrl())
                                <img src="{{ $post->coverUrl() }}" alt="" class="h-11 w-14 rounded-lg object-cover">
                            @endif
                            <div>
                                <span class="block text-[0.94rem] font-medium text-deep-900">{{ $post->title }}</span>
                                <span class="block text-xs text-muted">/{{ $post->slug }}</span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Category" class="px-5 py-4 text-sm text-muted">{{ $post->category }}</td>
                    <td data-label="Author" class="px-5 py-4 text-sm text-muted">{{ $post->author }}</td>
                    <td data-label="Published" class="px-5 py-4 text-sm text-muted">{{ $post->published_at?->format('j M Y') ?: '—' }}</td>
                    <td data-label="Status" class="px-5 py-4">
                        <x-admin.badge :tone="$post->is_published ? 'live' : 'draft'">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </x-admin.badge>
                    </td>
                    <td data-label="Actions" class="px-5 py-4">
                        <x-admin.row-actions :edit="route('admin.posts.edit', $post)" :delete="route('admin.posts.destroy', $post)"
                            :view="$post->is_published ? route('insights.show', $post) : null" confirm="Delete this post?" />
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
