<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class InsightController extends Controller
{
    public function index(): View
    {
        return view('site.insights.index', [
            'posts' => Post::published()->latestFirst()->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->is_published && (is_null($post->published_at) || $post->published_at->isPast()), 404);

        return view('site.insights.show', [
            'post' => $post,
            'more' => Post::published()->latestFirst()->whereKeyNot($post->id)->take(3)->get(),
        ]);
    }
}
