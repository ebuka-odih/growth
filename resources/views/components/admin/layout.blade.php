@props(['title' => 'Dashboard'])

@php
    $newEnquiries = \App\Models\Booking::where('status', 'new')->count();

    $nav = [
        ['group' => 'Overview', 'items' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'sphere'],
            ['label' => 'Enquiries', 'route' => 'admin.bookings.index', 'match' => 'admin.bookings.*', 'icon' => 'send', 'badge' => $newEnquiries],
        ]],
        ['group' => 'Agency', 'items' => [
            ['label' => 'Services', 'route' => 'admin.services.index', 'match' => 'admin.services.*', 'icon' => 'spark'],
            ['label' => 'Work', 'route' => 'admin.projects.index', 'match' => 'admin.projects.*', 'icon' => 'image'],
            ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'match' => 'admin.testimonials.*', 'icon' => 'user'],
        ]],
        ['group' => 'Community', 'items' => [
            ['label' => 'Cohorts', 'route' => 'admin.cohorts.index', 'match' => 'admin.cohorts.*', 'icon' => 'chart'],
            ['label' => 'Courses', 'route' => 'admin.courses.index', 'match' => 'admin.courses.*', 'icon' => 'monitor'],
            ['label' => 'Insights', 'route' => 'admin.posts.index', 'match' => 'admin.posts.*', 'icon' => 'play'],
            ['label' => 'Subscribers', 'route' => 'admin.subscribers.index', 'match' => 'admin.subscribers.*', 'icon' => 'phone'],
        ]],
        ['group' => 'Configuration', 'items' => [
            ['label' => 'Site settings', 'route' => 'admin.settings.edit', 'match' => 'admin.settings.*', 'icon' => 'sphere'],
        ]],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — GrowSphere Admin</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-lilac-soft font-sans antialiased">

    {{-- Drawer backdrop (mobile only) --}}
    <div data-drawer-backdrop
        class="fixed inset-0 z-40 hidden bg-deep-900/60 backdrop-blur-[2px] lg:hidden"></div>

    {{-- Sidebar: off-canvas drawer under lg, pinned column from lg up --}}
    <aside data-drawer
        class="fixed inset-y-0 left-0 z-50 flex w-[17rem] -translate-x-full flex-col bg-deep-900 text-lilac/70 transition-transform duration-300 ease-out lg:translate-x-0"
        aria-label="Admin navigation">

        <div class="flex items-center justify-between gap-3 px-5 py-5">
            <x-logo tone="light" :href="route('admin.dashboard')" />
            <button data-drawer-close type="button" aria-label="Close menu"
                class="-mr-1 flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-lilac/60 transition hover:bg-white/10 hover:text-white lg:hidden">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <nav class="min-h-0 flex-1 overflow-y-auto px-3 pb-5">
            @foreach ($nav as $section)
                <p class="px-3 pt-4 pb-2 text-[0.6rem] font-bold tracking-[0.16em] text-lilac/35 uppercase">
                    {{ $section['group'] }}
                </p>
                <ul class="space-y-0.5">
                    @foreach ($section['items'] as $item)
                        @php $active = request()->routeIs($item['match']); @endphp
                        <li>
                            <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition {{ $active ? 'bg-violet font-semibold text-white' : 'hover:bg-white/8 hover:text-white' }}">
                                <x-service-icon :name="$item['icon']" class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-lilac/45' }}" />
                                <span class="truncate">{{ $item['label'] }}</span>
                                @if (($item['badge'] ?? 0) > 0)
                                    <span
                                        class="ml-auto rounded-full px-2 py-0.5 text-[0.66rem] font-bold {{ $active ? 'bg-white text-violet' : 'bg-violet text-white' }}">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </nav>

        <div class="shrink-0 border-t border-white/10 px-3 py-4">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition hover:bg-white/8 hover:text-white">
                <x-mark class="h-4 w-4 shrink-0 text-lilac/45" />
                View site
                <svg class="ml-auto h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <path d="M7 17L17 7M9 7h8v8" />
                </svg>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm transition hover:bg-white/8 hover:text-white">
                    <svg class="h-4 w-4 shrink-0 text-lilac/45" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round">
                        <path d="M15 17l5-5-5-5M20 12H9M12 3H5v18h7" />
                    </svg>
                    Log out
                </button>
            </form>

            <p class="truncate px-3 pt-2.5 text-[0.7rem] text-lilac/35">{{ auth()->user()?->email }}</p>
        </div>
    </aside>

    {{-- Main column --}}
    <div class="flex min-h-screen min-w-0 flex-col lg:pl-[17rem]">

        {{-- Mobile top bar --}}
        <div
            class="sticky top-0 z-30 flex items-center gap-3 border-b border-deep/10 bg-white/95 px-4 py-3 backdrop-blur-md lg:hidden">
            <button data-drawer-open type="button" aria-label="Open menu" aria-expanded="false"
                class="relative flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center rounded-lg border border-deep/10 text-deep transition hover:bg-lilac">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                @if ($newEnquiries > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-violet px-1 text-[0.6rem] font-bold text-white">
                        {{ $newEnquiries }}
                    </span>
                @endif
            </button>

            <h1 class="min-w-0 flex-1 truncate text-[1.05rem] text-deep-900">{{ $title }}</h1>
        </div>

        <header class="border-b border-deep/10 bg-white px-5 py-5 lg:px-10 lg:py-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="hidden text-[1.5rem] text-deep-900 lg:block">{{ $title }}</h1>
                    @isset($subtitle)
                        <p class="text-sm text-muted lg:mt-1">{{ $subtitle }}</p>
                    @endisset
                </div>
                @isset($actions)
                    <div class="flex flex-wrap gap-2.5">{{ $actions }}</div>
                @endisset
            </div>
        </header>

        @if (session('status'))
            <div data-dismissable class="border-b border-violet/20 bg-violet/10 px-5 py-3.5 lg:px-10">
                <div class="flex items-center justify-between gap-4">
                    <p class="text-sm font-medium text-deep">{{ session('status') }}</p>
                    <button data-dismiss type="button" class="cursor-pointer text-deep/50 hover:text-deep"
                        aria-label="Dismiss">&times;</button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="border-b border-red-200 bg-red-50 px-5 py-3.5 lg:px-10">
                <p class="text-sm font-semibold text-red-800">Please fix the following:</p>
                <ul class="mt-1.5 list-disc space-y-1 pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main class="grow px-4 py-6 sm:px-5 lg:px-10 lg:py-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
