<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class CommunityController extends Controller
{
    public function index(): View
    {
        return view('site.community.index', [
            'cohorts' => Cohort::published()->ordered()->get(),
            'courses' => Course::published()->ordered()->get(),
            'testimonials' => Testimonial::published()->ordered()->take(3)->get(),
            'posts' => Post::published()->latestFirst()->take(2)->get(),
        ]);
    }

    public function cohort(Cohort $cohort): View
    {
        abort_unless($cohort->is_published, 404);

        return view('site.community.cohort', [
            'cohort' => $cohort,
            'others' => Cohort::published()->ordered()->whereKeyNot($cohort->id)->get(),
        ]);
    }

    public function course(Course $course): View
    {
        abort_unless($course->is_published, 404);

        return view('site.community.course', [
            'course' => $course,
            'others' => Course::published()->ordered()->whereKeyNot($course->id)->take(3)->get(),
        ]);
    }
}
