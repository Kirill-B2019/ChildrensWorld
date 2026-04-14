@extends('layouts.public')

@section('title', __('site.nav.reports'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.reports.title') }}</h1>
        <p class="mt-4 text-brand-muted">{{ __('site.reports.subtitle') }}</p>
        <div class="mt-8 grid gap-4">
            @php
                $fallbackReports = __('site.reports.items');
                $items = isset($reports) && $reports->isNotEmpty()
                    ? $reports->map(fn ($report) => [
                        'title' => $report->translationFor(app()->getLocale())?->title ?? '-',
                        'period' => $report->period ?? '-',
                        'url' => $report->file_path ? asset('storage/' . $report->file_path) : null,
                    ])
                    : collect($fallbackReports)->map(fn ($r) => [...$r, 'url' => null]);
            @endphp
            @foreach ($items as $item)
                <article class="card flex items-center justify-between">
                    <div>
                        <h2 class="font-display text-lg font-semibold">{{ $item['title'] }}</h2>
                        <p class="text-sm text-brand-muted">{{ $item['period'] }}</p>
                    </div>
                    @if(!empty($item['url']))
                        <a href="{{ $item['url'] }}" target="_blank" class="rounded-full bg-brand-bg px-3 py-1 text-xs font-semibold">{{ __('site.reports.public') }}</a>
                    @else
                        <span class="rounded-full bg-brand-bg px-3 py-1 text-xs font-semibold">{{ __('site.reports.public') }}</span>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
@endsection
