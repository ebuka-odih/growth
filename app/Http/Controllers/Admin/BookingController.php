<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $type = $request->query('type');

        return view('admin.bookings.index', [
            'bookings' => Booking::with(['cohort', 'course'])
                ->when($status, fn ($q) => $q->where('status', $status))
                ->when($type, fn ($q) => $q->where('type', $type))
                ->latest()
                ->paginate(25)
                ->withQueryString(),
            'status' => $status,
            'type' => $type,
            'counts' => [
                'all' => Booking::count(),
                'new' => Booking::where('status', 'new')->count(),
                'contacted' => Booking::where('status', 'contacted')->count(),
                'closed' => Booking::where('status', 'closed')->count(),
            ],
        ]);
    }

    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', [
            'booking' => $booking->load(['cohort', 'course']),
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $booking->update($request->validate([
            'status' => ['required', Rule::in(Booking::STATUSES)],
            'admin_notes' => ['nullable', 'string', 'max:4000'],
        ]));

        return back()->with('status', 'Enquiry updated.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('status', 'Enquiry deleted.');
    }
}
