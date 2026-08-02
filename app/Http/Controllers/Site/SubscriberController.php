<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc', 'max:190'],
            'name' => ['nullable', 'string', 'max:120'],
            'source' => ['nullable', 'string', 'max:60'],
        ]);

        Subscriber::firstOrCreate(
            ['email' => mb_strtolower($data['email'])],
            [
                'name' => $data['name'] ?? null,
                'source' => $data['source'] ?? 'footer',
            ],
        );

        return back()->with('status', "You're on the list. Growth notes are on the way.");
    }
}
