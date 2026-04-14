@extends('layouts.public')

@section('title', __('site.nav.blog'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.blog.title') }}</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @foreach (__('site.blog.posts') as $post)
                <article class="card">
                    <img
                        src="{{ asset('img/blog-' . $loop->iteration . '.webp') }}"
                        alt="{{ $post['title'] }}"
                        class="mb-4 h-48 w-full rounded-2xl object-cover"
                    >
                    <p class="text-xs uppercase tracking-wide text-brand-primary">{{ $post['date'] }}</p>
                    <h2 class="mt-2 font-display text-lg font-semibold">{{ $post['title'] }}</h2>
                    <p class="mt-3 text-sm text-brand-muted">{{ $post['excerpt'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
