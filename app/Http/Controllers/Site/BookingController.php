<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cohort;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function create(Request $request): View
    {
        return view('site.contact', [
            'cohorts' => Cohort::published()->open()->ordered()->get(),
            'courses' => Course::published()->ordered()->get(),
            'presetType' => in_array($request->query('type'), Booking::TYPES, true)
                ? $request->query('type')
                : 'project',
            'presetCohort' => $request->query('cohort'),
            'presetCourse' => $request->query('course'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(Booking::TYPES)],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:120'],
            'cohort_id' => ['nullable', 'exists:cohorts,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:4000'],
            // Honeypot: real users never fill this in.
            'website' => ['nullable', 'size:0'],
        ], [
            'website.size' => 'Something went wrong. Please try again.',
        ]);

        unset($data['website']);

        if ($data['type'] !== 'cohort') {
            $data['cohort_id'] = null;
        }

        if ($data['type'] !== 'course') {
            $data['course_id'] = null;
        }

        Booking::create($data + ['status' => 'new']);

        return redirect()
            ->route('contact')
            ->with('status', "Thank you — we've got your message and will reply within 24 hours.");
    }
}
