@extends('layouts.public')

@section('title', __('site.donate.qr_title'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.donate.qr_title') }}</h1>
        <p class="mt-3 text-brand-muted">{{ __('site.donate.qr_subtitle') }}</p>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <article class="card">
                <div class="mx-auto flex h-72 w-72 items-center justify-center rounded-2xl border-2 border-dashed border-brand-border bg-brand-bg p-4 text-center">
                    <p class="break-all text-xs">{{ $qrPayload }}</p>
                </div>
                <p class="mt-4 text-sm text-brand-muted">{{ __('site.donate.scan_hint') }}</p>
            </article>
            <article class="card">
                <p><strong>{{ __('site.donate.reference') }}:</strong> {{ $intent->external_reference }}</p>
                <p class="mt-2"><strong>{{ __('site.donate.amount') }}:</strong> {{ $intent->amount }} {{ $intent->currency }}</p>
                <p class="mt-2"><strong>{{ __('site.donate.status') }}:</strong> {{ strtoupper($intent->status) }}</p>

                <form method="POST" action="{{ route('donate.sandboxPaid', ['locale' => app()->getLocale(), 'intent' => $intent->id]) }}" class="mt-8">
                    @csrf
                    <button type="submit" class="rounded-full bg-brand-primary px-6 py-3 font-semibold text-white hover:bg-brand-primary-dark">
                        {{ __('site.donate.simulate_paid') }}
                    </button>
                </form>
            </article>
        </div>
    </section>
@endsection
