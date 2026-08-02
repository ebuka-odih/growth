@props([
    'title' => null,
    'description' => null,
])

@php
    // Resolved, so shipped defaults still apply on an install that has never been seeded.
    $settings = \App\Models\Setting::resolved();
    $metaTitle = $title ? $title . ' — GrowSphere Solutions' : 'GrowSphere Solutions — Branding, Growth & Creative Media';
    $metaDescription =
        $description ?:
        ($settings['mission'] ??
            'Branding, marketing, technology and creative media solutions for sustainable growth.');

    $navLinks = [
        ['label' => 'Services', 'route' => 'services.index', 'active' => 'services*'],
        ['label' => 'Work', 'route' => 'work.index', 'active' => 'work*'],
        ['label' => 'Community', 'route' => 'community.index', 'active' => 'community*'],
        ['label' => 'Insights', 'route' => 'insights.index', 'active' => 'insights*'],
        ['label' => 'About', 'route' => 'about', 'active' => 'about'],
    ];

    $socials = array_filter([
        'WhatsApp Community' => $settings['social_whatsapp_community'] ?? null,
        'WhatsApp' => $settings['social_whatsapp'] ?? null,
        'Instagram' => $settings['social_instagram'] ?? null,
        'LinkedIn' => $settings['social_linkedin'] ?? null,
        'X (Twitter)' => $settings['social_x'] ?? null,
        'YouTube' => $settings['social_youtube'] ?? null,
    ]);
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-pt-24">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 155) }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 155) }}">
    <meta property="og:image" content="{{ asset('images/brand/logo-reversed.jpg') }}">
    <meta property="og:type" content="website">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    {{-- Arms the scroll-reveal styles before first paint. Without JS the content just stays visible. --}}
    <script>document.documentElement.classList.add('js');</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <a href="#main"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100] focus:rounded-full focus:bg-deep focus:px-5 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <header class="sticky top-0 z-50 border-b border-deep/10 bg-paper/90 backdrop-blur-md">
        <div class="mx-auto flex h-[72px] max-w-6xl items-center justify-between px-6">
            <x-logo :href="route('home')" />

            <nav data-nav="flex"
                class="absolute top-[72px] right-0 left-0 hidden flex-col items-start gap-6 border-b border-deep/10 bg-paper px-6 pt-6 pb-8 shadow-[0_24px_40px_rgba(22,9,31,0.1)] lg:static lg:flex lg:flex-row lg:items-center lg:gap-8 lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                        class="py-1 text-[0.93rem] font-medium transition hover:text-violet {{ request()->routeIs($link['active']) ? 'text-violet' : 'text-ink' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <x-button :href="route('contact')" variant="primary" class="!px-6 !py-2.5">Start a project</x-button>
            </nav>

            <button data-nav-toggle type="button" aria-expanded="false" aria-label="Toggle navigation"
                class="p-2 lg:hidden">
                <span class="block h-0.5 w-6 bg-ink"></span>
                <span class="mt-1.5 block h-0.5 w-6 bg-ink"></span>
                <span class="mt-1.5 block h-0.5 w-6 bg-ink"></span>
            </button>
        </div>
    </header>

    @if (session('status'))
        <div data-dismissable class="border-b border-violet/20 bg-lilac">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-6 py-3">
                <p class="text-sm font-medium text-deep">{{ session('status') }}</p>
                <button data-dismiss type="button" class="text-deep/50 hover:text-deep" aria-label="Dismiss">&times;</button>
            </div>
        </div>
    @endif

    <main id="main">
        {{ $slot }}
    </main>

    <footer class="mt-24 bg-deep-900 text-lilac/70">
        <div class="mx-auto max-w-6xl px-6 py-16">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
                <div>
                    <x-logo tone="light" :href="route('home')" />
                    <p class="mt-5 max-w-xs text-sm leading-relaxed">
                        Branding, marketing, technology and creative media solutions for sustainable growth.
                    </p>
                    <p class="mt-5 text-sm">
                        <a href="mailto:{{ $settings['contact_email'] ?? 'growspheresolutions2@gmail.com' }}"
                            class="font-medium text-white hover:text-violet">
                            {{ $settings['contact_email'] ?? 'growspheresolutions2@gmail.com' }}
                        </a>
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white">Services</h4>
                    <ul class="mt-4 space-y-3 text-sm">
                        @foreach (\App\Models\Service::published()->ordered()->take(5)->get() as $service)
                            <li><a href="{{ route('services.show', $service) }}" class="hover:text-violet">{{ $service->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white">Community</h4>
                    <ul class="mt-4 space-y-3 text-sm">
                        <li><a href="{{ route('community.index') }}" class="hover:text-violet">Cohort programs</a></li>
                        <li><a href="{{ route('community.index') }}#courses" class="hover:text-violet">Skill courses</a></li>
                        <li><a href="{{ route('contact', ['type' => 'mentorship']) }}" class="hover:text-violet">1-on-1 mentorship</a></li>
                        <li><a href="{{ route('insights.index') }}" class="hover:text-violet">Insights</a></li>
                        @if ($settings['substack_url'] ?? null)
                            <li><a href="{{ $settings['substack_url'] }}" target="_blank" rel="noopener" class="hover:text-violet">Substack</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-white">Connect</h4>
                    @if ($socials)
                        <ul class="mt-4 space-y-3 text-sm">
                            @foreach ($socials as $label => $url)
                                <li><a href="{{ $url }}" target="_blank" rel="noopener" class="hover:text-violet">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-4 text-sm">Social links coming soon.</p>
                    @endif

                    <form method="POST" action="{{ route('subscribe') }}" class="mt-6">
                        @csrf
                        <label for="footer-email" class="text-xs font-semibold tracking-[0.14em] text-white uppercase">
                            Get growth notes
                        </label>
                        <div class="mt-2 flex gap-2">
                            <input id="footer-email" type="email" name="email" required placeholder="you@email.com"
                                class="w-full rounded-full border border-white/20 bg-white/5 px-4 py-2 text-sm text-white placeholder:text-lilac/40 focus:border-violet focus:outline-none">
                            <button type="submit"
                                class="shrink-0 rounded-full bg-violet px-4 py-2 text-sm font-semibold text-white transition hover:bg-violet-600">
                                Join
                            </button>
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-violet">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>

            <div
                class="mt-14 flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-7 text-xs">
                <span>&copy; {{ now()->year }} GrowSphere Solutions Limited. All rights reserved.</span>
                <span>Innovation · Professionalism · Excellence · Integrity · Creativity · Growth</span>
            </div>
        </div>
    </footer>
</body>

</html>
