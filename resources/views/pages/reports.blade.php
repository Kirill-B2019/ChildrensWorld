@extends('layouts.public')

@section('title', __('site.nav.reports'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.reports.title') }}</h1>
        <p class="mt-4 text-brand-muted">{{ __('site.reports.subtitle') }}</p>
        <div class="mt-8 grid gap-4">
            @foreach (__('site.reports.items') as $item)
                <article class="card flex items-center justify-between">
                    <div>
                        <h2 class="font-display text-lg font-semibold">{{ $item['title'] }}</h2>
                        <p class="text-sm text-brand-muted">{{ $item['period'] }}</p>
                    </div>
                    <span class="rounded-full bg-brand-bg px-3 py-1 text-xs font-semibold">{{ __('site.reports.public') }}</span>
                </article>
            @endforeach
        </div>
    </section>
@endsection
