@extends('layouts.public')

@section('title', __('site.nav.about'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.about.title') }}</h1>
        <p class="mt-6 max-w-3xl text-lg text-brand-muted">{{ __('site.about.text') }}</p>
    </section>
@endsection
