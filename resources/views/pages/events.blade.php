@extends('layouts.public')

@section('title', __('site.nav.events'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.events.title') }}</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach (__('site.events.list') as $event)
                <article class="card">
                    <img
                        src="{{ asset($loop->iteration % 2 === 0 ? 'img/event-3.webp' : 'img/event-2.webp') }}"
                        alt="{{ $event['title'] }}"
                        class="mb-4 h-52 w-full rounded-2xl object-cover"
                    >
                    <h2 class="font-display text-xl font-semibold">{{ $event['title'] }}</h2>
                    <p class="mt-2 text-sm text-brand-primary">{{ $event['date'] }} — {{ $event['location'] }}</p>
                    <p class="mt-3 text-brand-muted">{{ $event['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
