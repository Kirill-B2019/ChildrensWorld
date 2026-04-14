@extends('layouts.public')

@section('title', __('site.nav.programs'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.programs.title') }}</h1>
        <h2 class="mt-6 font-display text-2xl font-semibold">{{ __('site.programs.strategy_title') }}</h2>
        <p class="mt-3 max-w-4xl text-brand-muted">{{ __('site.programs.strategy_text') }}</p>

        @php
            $programPriorities = __('site.programs.priorities');
        @endphp

        @if (is_array($programPriorities))
            <div class="card mt-8 max-w-4xl">
                <h2 class="font-display text-xl font-semibold">{{ __('site.programs.priorities_title') }}</h2>
                <ul class="mt-4 space-y-2 text-sm text-brand-muted">
                    @foreach ($programPriorities as $priority)
                        <li>• {{ $priority }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach (__('site.programs.list') as $program)
                <article class="card">
                    <h2 class="font-display text-xl font-semibold">{{ $program['title'] }}</h2>
                    <p class="mt-3 text-brand-muted">{{ $program['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
