<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'New enquiries', 'value' => Booking::where('status', 'new')->count(), 'route' => route('admin.bookings.index'), 'accent' => true],
                ['label' => 'Services', 'value' => Service::count(), 'route' => route('admin.services.index')],
                ['label' => 'Projects', 'value' => Project::count(), 'route' => route('admin.projects.index')],
                ['label' => 'Cohorts', 'value' => Cohort::count(), 'route' => route('admin.cohorts.index')],
                ['label' => 'Courses', 'value' => Course::count(), 'route' => route('admin.courses.index')],
                ['label' => 'Posts', 'value' => Post::count(), 'route' => route('admin.posts.index')],
                ['label' => 'Testimonials', 'value' => Testimonial::count(), 'route' => route('admin.testimonials.index')],
                ['label' => 'Subscribers', 'value' => Subscriber::count(), 'route' => route('admin.subscribers.index')],
            ],
            'recentBookings' => Booking::with(['cohort', 'course'])->latest()->take(6)->get(),
            'draftPosts' => Post::where('is_published', false)->latest()->take(5)->get(),
            'openCohorts' => Cohort::published()->open()->ordered()->get(),
        ]);
    }
}
