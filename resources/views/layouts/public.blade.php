<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
    $supportedLocales = ['en', 'ru', 'ky'];
    $locale = app()->getLocale();
    $withLocale = fn (string $route) => route($route, ['locale' => $locale]);
    $currentRouteName = optional(request()->route())->getName();
    $baseParams = request()->route()?->parameters() ?? [];

    $localizedUrl = function (string $targetLocale) use ($currentRouteName, $baseParams): string {
        if (! $currentRouteName) {
            return $targetLocale === 'en'
                ? route('home')
                : route('home.localized', ['locale' => $targetLocale]);
        }

        $params = $baseParams;
        $params['locale'] = $targetLocale;

        if ($currentRouteName === 'home') {
            return $targetLocale === 'en'
                ? route('home')
                : route('home.localized', ['locale' => $targetLocale]);
        }

        if ($currentRouteName === 'home.localized' && $targetLocale === 'en') {
            return route('home');
        }

        return route($currentRouteName, $params);
    };

    $canonicalUrl = $localizedUrl($locale);
    $alternateUrls = collect($supportedLocales)->mapWithKeys(
        fn (string $lang) => [$lang => $localizedUrl($lang)]
    );
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', __('site.meta.default_description'))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="en" href="{{ $alternateUrls['en'] }}">
    <link rel="alternate" hreflang="ru" href="{{ $alternateUrls['ru'] }}">
    <link rel="alternate" hreflang="ky" href="{{ $alternateUrls['ky'] }}">
    @yield('hreflang')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ mobileMenuOpen: false }" class="bg-brand-bg text-brand-text font-body antialiased">

    <header class="sticky top-0 z-40 border-b border-brand-border/50 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ $locale === 'en' ? route('home') : route('home.localized', ['locale' => $locale]) }}" class="focus-ring font-display text-xl font-bold text-brand-primary">
                Future for Children
            </a>
            @php
                $navItems = [
                    ['route' => 'about', 'label' => __('site.nav.about')],
                    ['route' => 'programs', 'label' => __('site.nav.programs')],
                    ['route' => 'children', 'label' => __('site.nav.children')],
                    ['route' => 'events', 'label' => __('site.nav.events')],
                    ['route' => 'blog', 'label' => __('site.nav.blog')],
                    ['route' => 'reports', 'label' => __('site.nav.reports')],
                    ['route' => 'contact', 'label' => __('site.nav.contact')],
                ];
            @endphp

            <nav class="hidden items-center gap-2 text-sm font-medium lg:flex">
                @foreach($navItems as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <a
                        href="{{ $withLocale($item['route']) }}"
                        class="focus-ring rounded-full px-4 py-2 {{ $isActive ? 'bg-brand-primary text-white' : 'text-brand-text hover:text-brand-primary' }}"
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ $withLocale('donate') }}" class="focus-ring hidden rounded-full bg-brand-primary px-4 py-2 text-sm font-semibold text-white hover:bg-brand-primary-dark sm:inline-flex">
                    {{ __('site.actions.donate') }}
                </a>
                <div class="flex items-center overflow-hidden rounded-full border border-brand-border">
                    @foreach ($supportedLocales as $lang)
                        <a
                            href="{{ $alternateUrls[$lang] }}"
                            class="focus-ring px-3 py-2 text-xs font-semibold {{ $lang === $locale ? 'bg-brand-primary text-white' : 'bg-white text-brand-text' }}"
                        >
                            {{ strtoupper($lang) }}
                        </a>
                    @endforeach
                </div>
                <button
                    type="button"
                    class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-border text-brand-text lg:hidden"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    :aria-expanded="mobileMenuOpen.toString()"
                    aria-controls="mobile-navigation"
                    aria-label="Toggle navigation"
                >
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div
            id="mobile-navigation"
            x-show="mobileMenuOpen"
            x-transition
            @click.away="mobileMenuOpen = false"
            class="border-t border-brand-border/70 bg-white lg:hidden"
            x-cloak
        >
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
                <nav class="grid gap-2">
                    @foreach($navItems as $item)
                        @php $isActive = request()->routeIs($item['route']); @endphp
                        <a
                            href="{{ $withLocale($item['route']) }}"
                            class="focus-ring rounded-xl px-4 py-3 text-sm font-medium {{ $isActive ? 'bg-brand-primary text-white' : 'bg-brand-bg text-brand-text' }}"
                            @click="mobileMenuOpen = false"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <a
                        href="{{ $withLocale('donate') }}"
                        class="focus-ring btn-primary mt-2"
                        @click="mobileMenuOpen = false"
                    >
                        {{ __('site.actions.donate') }}
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-brand-border bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div>
                <h3 class="font-display text-lg font-semibold">{{ __('site.footer.title') }}</h3>
                <p class="mt-3 text-sm text-brand-muted">{{ __('site.footer.subtitle') }}</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-brand-muted">{{ __('site.footer.company') }}</h4>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ $withLocale('about') }}">{{ __('site.nav.about') }}</a></li>
                    <li><a href="{{ $withLocale('programs') }}">{{ __('site.nav.programs') }}</a></li>
                    <li><a href="{{ $withLocale('events') }}">{{ __('site.nav.events') }}</a></li>
                    <li><a href="{{ $withLocale('children') }}">{{ __('site.nav.children') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-brand-muted">{{ __('site.footer.resources') }}</h4>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a href="{{ $withLocale('blog') }}">{{ __('site.nav.blog') }}</a></li>
                    <li><a href="{{ $withLocale('faq') }}">{{ __('site.nav.faq') }}</a></li>
                    <li><a href="{{ $withLocale('terms') }}">{{ __('site.nav.terms') }}</a></li>
                    <li><a href="{{ $withLocale('privacy') }}">{{ __('site.nav.privacy') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-brand-border/70 py-3 text-center text-xs text-brand-muted">
            | KB @CerberRus00
        </div>
    </footer>
</body>
</html>
