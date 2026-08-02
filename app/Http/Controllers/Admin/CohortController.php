<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CohortController extends Controller
{
    public function index(): View
    {
        return view('admin.cohorts.index', [
            'cohorts' => Cohort::withCount('bookings')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cohorts.form', [
            'cohort' => new Cohort(['is_published' => true, 'has_certificate' => true, 'status' => 'upcoming', 'duration' => '3 weeks']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Cohort::create($this->validated($request));

        return redirect()->route('admin.cohorts.index')->with('status', 'Cohort created.');
    }

    public function edit(Cohort $cohort): View
    {
        return view('admin.cohorts.form', compact('cohort'));
    }

    public function update(Request $request, Cohort $cohort): RedirectResponse
    {
        $cohort->update($this->validated($request, $cohort));

        return redirect()->route('admin.cohorts.index')->with('status', 'Cohort updated.');
    }

    public function destroy(Cohort $cohort): RedirectResponse
    {
        $cohort->delete();

        return redirect()->route('admin.cohorts.index')->with('status', 'Cohort deleted.');
    }

    private function validated(Request $request, ?Cohort $cohort = null): array
    {
        $data = $request->validate([
            'code' => ['nullable', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:140'],
            'slug' => ['nullable', 'string', 'max:160', Rule::unique('cohorts', 'slug')->ignore($cohort?->id)],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'curriculum' => ['nullable', 'string'],
            'duration' => ['required', 'string', 'max:60'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'starts_on' => ['nullable', 'date'],
            'status' => ['required', Rule::in(Cohort::STATUSES)],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['position'] = $data['position'] ?? 0;
        $data['has_certificate'] = $request->boolean('has_certificate');
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
