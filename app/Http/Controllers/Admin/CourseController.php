<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesMediaUploads;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    use HandlesMediaUploads;

    public function index(): View
    {
        return view('admin.courses.index', [
            'courses' => Course::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.courses.form', [
            'course' => new Course(['is_published' => true, 'level' => 'Foundation', 'format' => 'Self-paced']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $course = Course::create($data);
        $this->syncMedia($request, $course, 'courses');

        return redirect()->route('admin.courses.index')->with('status', 'Course created.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validated($request, $course);

        $course->update($data);
        $this->syncMedia($request, $course, 'courses');

        return redirect()->route('admin.courses.index')->with('status', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('status', 'Course deleted.');
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('courses', 'slug')->ignore($course?->id)],
            'category' => ['nullable', 'string', 'max:80'],
            'level' => ['required', 'string', 'max:40'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'outcomes' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'format' => ['nullable', 'string', 'max:80'],
            'position' => ['nullable', 'integer', 'min:0'],
            ...$this->mediaRules($request, $course, Course::MEDIA_LIMIT),
        ]);

        $data = Arr::except($data, $this->mediaInputKeys());

        $data['position'] = $data['position'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
