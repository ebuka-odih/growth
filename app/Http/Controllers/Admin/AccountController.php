<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.account', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $user->update($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
        ]));

        return back()->with('status', 'Account details updated.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(10)->letters()->numbers()->uncompromised()],
        ], [
            'current_password.current_password' => 'That is not your current password.',
            'password.uncompromised' => 'That password has appeared in a public data breach. Please choose another.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Keep this session valid but invalidate the old session fixation vector.
        $request->session()->regenerate();

        return back()->with('status', 'Password changed. Use it the next time you log in.');
    }

    /**
     * Whether the account still uses the password the installer seeded.
     * Surfaced as a warning until it is changed.
     */
    public static function usesSeededPassword(): bool
    {
        $user = Auth::user();

        return $user !== null && Hash::check('growsphere', $user->password);
    }
}
