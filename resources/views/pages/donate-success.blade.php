@extends('layouts.public')

@section('title', __('site.donate.success_title'))

@section('content')
    <section class="section-wrap py-20">
        <article class="card mx-auto max-w-2xl text-center">
            <h1 class="font-display text-4xl font-bold text-brand-primary">{{ __('site.donate.success_title') }}</h1>
            <p class="mt-4 text-brand-muted">{{ __('site.donate.success_text') }}</p>
            <p class="mt-6 text-sm"><strong>{{ __('site.donate.reference') }}:</strong> {{ $intent->external_reference }}</p>
            <a href="{{ route('home.localized', ['locale' => app()->getLocale()]) }}" class="mt-8 inline-block rounded-full bg-brand-primary px-6 py-3 font-semibold text-white hover:bg-brand-primary-dark">
                {{ __('site.actions.back_home') }}
            </a>
        </article>
    </section>
@endsection
