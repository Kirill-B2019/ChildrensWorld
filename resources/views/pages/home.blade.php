@extends('layouts.public')

@section('title', __('site.meta.home_title'))
@section('description', __('site.meta.home_description'))

@section('content')
    <section class="section-wrap py-16 lg:py-24">
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div>
                <p class="font-display text-sm font-semibold uppercase tracking-wide text-brand-primary">{{ __('site.hero.badge') }}</p>
                <h1 class="mt-4 font-display text-4xl font-extrabold leading-tight sm:text-5xl">{{ $homeTranslation?->title ?: __('site.hero.title') }}</h1>
                <p class="mt-6 max-w-xl text-lg text-brand-muted">{{ $homeTranslation?->body ?: __('site.hero.subtitle') }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('donate', ['locale' => app()->getLocale()]) }}" class="rounded-full bg-brand-primary px-6 py-3 font-semibold text-white hover:bg-brand-primary-dark">{{ __('site.actions.donate') }}</a>
                    <a href="{{ route('programs', ['locale' => app()->getLocale()]) }}" class="rounded-full border border-brand-border px-6 py-3 font-semibold">{{ __('site.actions.view_programs') }}</a>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-3xl">
                <img src="{{ asset('img/hero-evening.webp') }}" alt="Hero" class="h-[420px] w-full object-cover sm:h-[500px]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                    <h2 class="font-display text-2xl font-semibold text-white">{{ __('site.mission.title') }}</h2>
                    <p class="mt-4 max-w-md text-gray-100">{{ __('site.mission.text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-wrap pb-16">
        <div class="mb-8 grid grid-cols-2 gap-4 rounded-2xl bg-white p-4 sm:grid-cols-4">
            @foreach (['logo-2.webp', 'logo-3.webp', 'logo-5.webp', 'logo-6.webp'] as $logo)
                <div class="flex items-center justify-center rounded-xl border border-brand-border bg-brand-bg px-3 py-4">
                    <img src="{{ asset('img/' . $logo) }}" alt="Partner logo" class="h-10 w-auto object-contain">
                </div>
            @endforeach
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="card text-center">
                    <p class="font-display text-3xl font-bold text-brand-primary">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm text-brand-muted">{{ $stat['label'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-wrap pb-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="section-title">{{ __('site.programs.title') }}</h2>
                <p class="mt-3 text-brand-muted">{{ __('site.programs.subtitle') }}</p>
            </div>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach ($programs as $program)
                <article class="card">
                    <img
                        src="{{ asset($loop->odd ? 'img/program-teacher.webp' : 'img/program-scholarship.webp') }}"
                        alt="{{ $program['title'] }}"
                        class="mb-4 h-48 w-full rounded-2xl object-cover"
                    >
                    <h3 class="font-display text-xl font-semibold">{{ $program['title'] }}</h3>
                    <p class="mt-3 text-sm text-brand-muted">{{ __('site.programs.raised') }}: ${{ $program['raised'] }} / ${{ $program['goal'] }}</p>
                    <div class="mt-4 h-2 rounded-full bg-gray-200">
                        <div class="h-2 w-3/4 rounded-full bg-brand-primary"></div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-wrap pb-16">
        <div class="card">
            <h2 class="section-title">{{ __('site.donation_flow.title') }}</h2>
            <div class="mt-8 grid gap-4 md:grid-cols-4">
                @foreach (__('site.donation_flow.steps') as $step)
                    <div class="rounded-xl bg-brand-bg p-4">
                        <img
                            src="{{ asset('img/step-' . $loop->iteration . ($loop->iteration === 1 ? '.webp' : '.jpg')) }}"
                            alt="{{ $step['title'] }}"
                            class="mb-3 h-28 w-full rounded-xl object-cover"
                        >
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-primary">{{ $loop->iteration }}</p>
                        <p class="mt-2 font-display text-lg font-semibold">{{ $step['title'] }}</p>
                        <p class="mt-2 text-sm text-brand-muted">{{ $step['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-wrap pb-16">
        <div class="grid gap-6 lg:grid-cols-2">
            <article class="card overflow-hidden">
                <img src="{{ asset('img/child-group.webp') }}" alt="Children" class="h-72 w-full rounded-2xl object-cover">
                <h3 class="mt-4 font-display text-2xl font-semibold">{{ __('site.children.title') }}</h3>
                <p class="mt-2 text-brand-muted">{{ __('site.hero.subtitle') }}</p>
            </article>
            <article class="card overflow-hidden">
                <img src="{{ asset('img/testimonial-4.webp') }}" alt="Testimonial" class="h-72 w-full rounded-2xl object-cover">
                <h3 class="mt-4 font-display text-2xl font-semibold">{{ __('site.blog.title') }}</h3>
                <p class="mt-2 text-brand-muted">{{ __('site.programs.subtitle') }}</p>
            </article>
        </div>
    </section>
@endsection
