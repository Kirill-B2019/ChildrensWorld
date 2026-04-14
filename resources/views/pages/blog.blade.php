@extends('layouts.public')

@section('title', __('site.nav.blog'))

@section('content')
    <section class="section-wrap section-block">
        <h1 class="section-title">{{ __('site.blog.title') }}</h1>
        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach (__('site.blog.posts') as $post)
                <a href="#" class="card-media group focus-ring">
                    <img
                        src="{{ asset('img/blog-' . $loop->iteration . '.webp') }}"
                        alt="{{ $post['title'] }}"
                        class="card-media-image"
                    >
                    <div class="card-media-body">
                        <p class="text-xs uppercase tracking-wide text-brand-primary">{{ $post['date'] }}</p>
                        <h2 class="mt-2 min-h-[56px] font-display text-lg font-semibold">{{ $post['title'] }}</h2>
                        <p class="mt-3 text-sm text-brand-muted">{{ $post['excerpt'] }}</p>
                        <p class="mt-4 text-sm font-semibold text-brand-primary">Read update</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
