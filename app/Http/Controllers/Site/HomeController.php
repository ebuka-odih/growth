<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('site.home', [
            'services' => Service::published()->ordered()->get(),
            'projects' => Project::published()->ordered()->take(6)->get(),
            'cohorts' => Cohort::published()->ordered()->get(),
            'testimonials' => Testimonial::published()->ordered()->take(3)->get(),
            'posts' => Post::published()->latestFirst()->take(3)->get(),
        ]);
    }
}
