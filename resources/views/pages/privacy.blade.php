@extends('layouts.public')

@section('title', __('site.nav.privacy'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.privacy.title') }}</h1>
        <article class="card mt-8 space-y-4 text-brand-muted">
            <p>{{ __('site.privacy.p1') }}</p>
            <p>{{ __('site.privacy.p2') }}</p>
            <p>{{ __('site.privacy.p3') }}</p>
        </article>
    </section>
@endsection
