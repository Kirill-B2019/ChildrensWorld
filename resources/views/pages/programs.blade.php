@extends('layouts.public')

@section('title', __('site.nav.programs'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.programs.title') }}</h1>
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
