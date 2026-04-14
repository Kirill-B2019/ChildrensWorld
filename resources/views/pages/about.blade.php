@extends('layouts.public')

@section('title', __('site.nav.about'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.about.title') }}</h1>
        <p class="mt-6 max-w-3xl text-lg text-brand-muted">{{ __('site.about.text') }}</p>

        @php
            $aboutParagraphs = __('site.about.paragraphs');
            $aboutPrinciples = __('site.about.principles');
        @endphp

        @if (is_array($aboutParagraphs))
            <div class="mt-8 grid gap-4">
                @foreach ($aboutParagraphs as $paragraph)
                    <p class="max-w-4xl text-brand-muted">{{ $paragraph }}</p>
                @endforeach
            </div>
        @endif

        @if (is_array($aboutPrinciples))
            <div class="card mt-10 max-w-4xl">
                <h2 class="font-display text-xl font-semibold">{{ __('site.about.principles_title') }}</h2>
                <ul class="mt-4 space-y-2 text-sm text-brand-muted">
                    @foreach ($aboutPrinciples as $principle)
                        <li>• {{ $principle }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>
@endsection
