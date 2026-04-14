@extends('layouts.public')

@section('title', __('site.nav.children'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.children.title') }}</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @foreach (__('site.children.cards') as $card)
                <article class="card">
                    <h2 class="font-display text-lg font-semibold">{{ $card['name'] }}</h2>
                    <p class="mt-2 text-sm text-brand-primary">{{ $card['goal'] }}</p>
                    <p class="mt-3 text-sm text-brand-muted">{{ $card['story'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
