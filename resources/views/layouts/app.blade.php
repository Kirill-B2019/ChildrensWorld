<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <aside class="w-72 shrink-0 border-r border-gray-200 bg-white min-h-screen">
                <div class="px-6 py-5">
                    <a href="{{ route('dashboard') }}" class="text-lg font-bold text-indigo-700">
                        {{ config('app.name', 'Laravel') }} CMS
                    </a>
                </div>

                <nav class="space-y-1 px-3 pb-5">
                    <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.dashboard') }}</a>
                    <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.profile') }}</a>

                    @if (auth()->user()?->email === config('cms.admin_email', 'test@test.com'))
                        <div class="mt-4 px-3 text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('admin.sidebar.cms') }}</div>
                        <a href="{{ route('admin.content.pages.index') }}" class="mt-1 block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.pages.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.pages') }}</a>
                        <a href="{{ route('admin.content.posts.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.posts.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.blog') }}</a>
                        <a href="{{ route('admin.content.events.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.events.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.events') }}</a>
                        <a href="{{ route('admin.content.reports.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.reports.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.reports') }}</a>
                        <a href="{{ route('admin.content.donations.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.donations.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.donations') }}</a>
                        <a href="{{ route('admin.content.settings.edit') }}" class="block rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.content.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">{{ __('admin.sidebar.settings') }}</a>
                    @endif
                </nav>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="border-b bg-white shadow-sm">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                        <div>
                            @isset($header)
                                {{ $header }}
                            @else
                                <h2 class="text-lg font-semibold text-gray-800">{{ __('admin.dashboard.title') }}</h2>
                            @endisset
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center overflow-hidden rounded-md border border-gray-300">
                                @foreach (['en' => 'EN', 'ru' => 'RU', 'kg' => 'KG'] as $lang => $label)
                                    <a href="{{ route('dashboard.locale', ['locale' => $lang]) }}" class="px-2 py-1 text-xs font-semibold {{ app()->getLocale() === $lang ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700' }}">{{ $label }}</a>
                                @endforeach
                            </div>
                            <span class="hidden text-sm text-gray-600 sm:inline">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="rounded-md border border-gray-300 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-100">{{ __('admin.actions.logout') }}</button>
                            </form>
                        </div>
                    </div>
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
