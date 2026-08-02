<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    use HandlesUploads;

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
        $data = $this->withUpload($data, 'image', $this->handleUpload($request, 'image', 'courses'));

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('status', 'Course created.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validated($request, $course);
        $data = $this->withUpload($data, 'image', $this->handleUpload($request, 'image', 'courses', $course->image));

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('status', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->deleteUpload($course->image);
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
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($data['image']);

        $data['position'] = $data['position'] ?? 0;
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
