@extends('layouts.public')

@section('title', __('site.nav.faq'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.faq.title') }}</h1>
        <div class="mt-8 space-y-4">
            @foreach (__('site.faq.items') as $item)
                <article class="card">
                    <h2 class="font-display text-lg font-semibold">{{ $item['q'] }}</h2>
                    <p class="mt-2 text-brand-muted">{{ $item['a'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
