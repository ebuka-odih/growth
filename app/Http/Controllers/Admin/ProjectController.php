<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesMediaUploads;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\Url;
use App\Support\Video;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use HandlesMediaUploads;

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project(['is_published' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $project = Project::create($data);
        $this->syncMedia($request, $project, 'projects');

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project);

        $project->update($data);
        $this->syncMedia($request, $project, 'projects');

        return redirect()->route('admin.projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        $request->merge([
            'website_url' => Url::normalize($request->input('website_url')),
            'video_url' => Url::normalize($request->input('video_url')),
        ]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'client' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:80'],
            'disciplines' => ['nullable', 'string', 'max:160'],
            'year' => ['nullable', 'string', 'max:20'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:255', function (string $attribute, mixed $value, callable $fail) {
                if (! Video::isSupported($value)) {
                    $fail('Paste a YouTube or Vimeo link.');
                }
            }],
            'summary' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            ...$this->mediaRules($request, $project, Project::MEDIA_LIMIT),
        ]);

        $data = Arr::except($data, $this->mediaInputKeys());

        $data['position'] = $data['position'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
