@php
    $usingSeeded = \App\Http\Controllers\Admin\AccountController::usesSeededPassword();
@endphp

<x-admin.layout title="Account & security">
    <x-slot:subtitle>Your login details for this admin panel.</x-slot:subtitle>

    @if ($usingSeeded)
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-amber-300 bg-amber-50 p-5">
            <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-amber-400 text-white">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round">
                    <path d="M12 8v5M12 17h.01" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-semibold text-amber-900">You're still using the password this site shipped with.</p>
                <p class="mt-1 text-sm text-amber-800">
                    It is the same for every copy of this project, so anyone who knows it can sign in here and edit the
                    public site. Change it below.
                </p>
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Password --}}
        <x-admin.panel title="Change password"
            description="You'll stay signed in on this device. Use the new password next time you log in.">
            <form method="POST" action="{{ route('admin.account.password') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <x-admin.field label="Current password" name="current_password" type="password" required
                    autocomplete="current-password" />

                <x-admin.field label="New password" name="password" type="password" required
                    autocomplete="new-password"
                    help="At least 10 characters, including a letter and a number. Checked against known breached passwords." />

                <x-admin.field label="Confirm new password" name="password_confirmation" type="password" required
                    autocomplete="new-password" />

                <x-button variant="accent" type="submit">Change password</x-button>
            </form>
        </x-admin.panel>

        <div class="space-y-6">
            {{-- Profile --}}
            <x-admin.panel title="Login details" description="The email address you sign in with.">
                <form method="POST" action="{{ route('admin.account.profile') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <x-admin.field label="Name" name="name" :value="$user->name" required />
                    <x-admin.field label="Email" name="email" type="email" :value="$user->email" required
                        help="Changing this changes the address you log in with." />

                    <x-button variant="primary" type="submit">Save details</x-button>
                </form>
            </x-admin.panel>

            <x-admin.panel title="Keeping this admin secure">
                <ul class="space-y-3 text-[0.92rem] text-ink">
                    @foreach ([
                        'Use a password you do not use anywhere else.',
                        'Do not share one login — ask for a separate account per person, so access can be removed individually.',
                        'Log out when using a shared or public computer.',
                        'GrowSphere will never ask for your password by email or WhatsApp.',
                    ] as $tip)
                        <li class="flex items-start gap-3">
                            <span
                                class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-violet text-white">
                                <x-service-icon name="check" class="h-3 w-3" />
                            </span>
                            {{ $tip }}
                        </li>
                    @endforeach
                </ul>
            </x-admin.panel>
        </div>
    </div>
</x-admin.layout>
