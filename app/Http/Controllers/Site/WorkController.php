<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Project::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $category = $request->query('category');

        $projects = Project::published()
            ->ordered()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->get();

        return view('site.work.index', compact('projects', 'categories', 'category'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        return view('site.work.show', [
            'project' => $project,
            'more' => Project::published()->ordered()->whereKeyNot($project->id)->take(3)->get(),
        ]);
    }
}
