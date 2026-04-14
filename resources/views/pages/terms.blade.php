@extends('layouts.public')

@section('title', __('site.nav.terms'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.terms.title') }}</h1>
        <article class="card mt-8 space-y-4 text-brand-muted">
            <p>{{ __('site.terms.p1') }}</p>
            <p>{{ __('site.terms.p2') }}</p>
            <p>{{ __('site.terms.p3') }}</p>
        </article>
    </section>
@endsection
