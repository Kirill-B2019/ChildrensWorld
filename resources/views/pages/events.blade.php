@extends('layouts.public')

@section('title', __('site.nav.events'))

@section('content')
    <section class="section-wrap section-block">
        <h1 class="section-title">{{ __('site.events.title') }}</h1>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            @php
                $fallbackEvents = __('site.events.list');
                $items = isset($events) && $events->isNotEmpty()
                    ? $events->map(fn ($event) => [
                        'title' => $event->translationFor(app()->getLocale())?->title ?? '-',
                        'text' => $event->translationFor(app()->getLocale())?->text ?? '',
                        'date' => optional($event->event_date)->format('d M Y H:i') ?? '',
                        'location' => $event->location ?? '',
                    ])
                    : collect($fallbackEvents);
            @endphp
            @foreach ($items as $event)
                <a href="#" class="card-media group focus-ring">
                    <img
                        src="{{ asset($loop->iteration % 2 === 0 ? 'img/event-3.webp' : 'img/event-2.webp') }}"
                        alt="{{ $event['title'] }}"
                        class="card-media-image"
                    >
                    <div class="card-media-body">
                        <h2 class="font-display text-xl font-semibold">{{ $event['title'] }}</h2>
                        <p class="mt-2 text-sm text-brand-primary">{{ $event['date'] }} — {{ $event['location'] }}</p>
                        <p class="mt-3 text-brand-muted">{{ $event['text'] }}</p>
                        <p class="mt-4 text-sm font-semibold text-brand-primary">View details</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
