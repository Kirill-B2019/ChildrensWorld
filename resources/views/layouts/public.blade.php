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
<body class="bg-brand-bg text-brand-text font-body antialiased">

    <header class="sticky top-0 z-40 border-b border-brand-border/50 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ $locale === 'en' ? route('home') : route('home.localized', ['locale' => $locale]) }}" class="font-display text-xl font-bold text-brand-primary">
                Future for Children
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium lg:flex">
                <a href="{{ $withLocale('about') }}" class="hover:text-brand-primary">{{ __('site.nav.about') }}</a>
                <a href="{{ $withLocale('programs') }}" class="hover:text-brand-primary">{{ __('site.nav.programs') }}</a>
                <a href="{{ $withLocale('children') }}" class="hover:text-brand-primary">{{ __('site.nav.children') }}</a>
                <a href="{{ $withLocale('events') }}" class="hover:text-brand-primary">{{ __('site.nav.events') }}</a>
                <a href="{{ $withLocale('blog') }}" class="hover:text-brand-primary">{{ __('site.nav.blog') }}</a>
                <a href="{{ $withLocale('reports') }}" class="hover:text-brand-primary">{{ __('site.nav.reports') }}</a>
                <a href="{{ $withLocale('contact') }}" class="hover:text-brand-primary">{{ __('site.nav.contact') }}</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ $withLocale('donate') }}" class="rounded-full bg-brand-primary px-4 py-2 text-sm font-semibold text-white hover:bg-brand-primary-dark">
                    {{ __('site.actions.donate') }}
                </a>
                <div class="flex items-center overflow-hidden rounded-full border border-brand-border">
                    @foreach ($supportedLocales as $lang)
                        <a
                            href="{{ $alternateUrls[$lang] }}"
                            class="px-3 py-2 text-xs font-semibold {{ $lang === $locale ? 'bg-brand-primary text-white' : 'bg-white text-brand-text' }}"
                        >
                            {{ strtoupper($lang) }}
                        </a>
                    @endforeach
                </div>
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
    </footer>
</body>
</html>
