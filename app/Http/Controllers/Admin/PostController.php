<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::latestFirst()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(['category' => 'Insight', 'author' => 'GrowSphere', 'is_published' => false]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data = $this->withUpload($data, 'cover', $this->handleUpload($request, 'cover', 'posts'));

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('status', 'Post created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post);
        $data = $this->withUpload($data, 'cover', $this->handleUpload($request, 'cover', 'posts', $post->cover));

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->deleteUpload($post->cover);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('posts', 'slug')->ignore($post?->id)],
            'category' => ['required', 'string', 'max:60'],
            'author' => ['nullable', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($data['cover']);

        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['published_at'] ?? null;

        // Publishing without an explicit date means "publish now".
        if ($data['is_published'] && blank($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
