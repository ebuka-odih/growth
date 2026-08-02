<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in — GrowSphere Admin</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex min-h-screen items-center justify-center bg-deep-900 px-6 font-sans antialiased">
    <div class="pointer-events-none absolute inset-0 brand-pattern"></div>

    <div class="relative w-full max-w-md">
        <div class="flex justify-center">
            <x-logo tone="light" :href="route('home')" />
        </div>

        <div class="mt-8 rounded-[var(--radius-brand)] bg-white p-9 shadow-[0_30px_70px_rgba(0,0,0,0.35)]">
            <h1 class="text-xl text-deep-900">Admin log in</h1>
            <p class="mt-1.5 text-sm text-muted">Manage cohorts, work, insights and enquiries.</p>

            <form method="POST" action="{{ route('admin.login') }}" class="mt-7 space-y-5">
                @csrf

                <x-admin.field label="Email" name="email" type="email" required placeholder="you@example.com" />
                <x-admin.field label="Password" name="password" type="password" required placeholder="••••••••" />

                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-muted">
                    <input type="checkbox" name="remember" value="1" class="accent-[#9900CC]">
                    Keep me logged in
                </label>

                <x-button variant="accent" type="submit" class="w-full">Log in</x-button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-lilac/50">
            <a href="{{ route('home') }}" class="hover:text-white">&larr; Back to the site</a>
        </p>
    </div>
</body>

</html>
