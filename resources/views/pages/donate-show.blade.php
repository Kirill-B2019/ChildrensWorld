@extends('layouts.public')

@section('title', __('site.donate.qr_title'))

@section('content')
    <section class="section-wrap section-block">
        <h1 class="section-title">{{ __('site.donate.qr_title') }}</h1>
        <p class="mt-3 text-brand-muted">{{ __('site.donate.qr_subtitle') }}</p>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <article class="card">
                <h2 class="font-display text-xl font-semibold">Scan to pay</h2>
                <div class="mx-auto mt-4 flex h-72 w-72 items-center justify-center rounded-2xl border-2 border-dashed border-brand-border bg-brand-bg p-4 text-center">
                    <p class="break-all text-xs text-brand-muted">{{ $qrPayload }}</p>
                </div>
                <p class="mt-4 text-sm text-brand-muted">{{ __('site.donate.scan_hint') }}</p>
                <p class="mt-2 text-xs text-brand-muted">Session expires at: {{ optional($intent->expires_at)->format('H:i') ?? '-' }}</p>
            </article>
            <article class="card">
                <h2 class="font-display text-xl font-semibold">Payment details</h2>
                <div class="mt-4 rounded-xl bg-brand-bg p-4">
                    <p><strong>{{ __('site.donate.reference') }}:</strong> {{ $intent->external_reference }}</p>
                    <p class="mt-2"><strong>{{ __('site.donate.amount') }}:</strong> {{ $intent->amount }} {{ $intent->currency }}</p>
                    <p class="mt-2"><strong>{{ __('site.donate.status') }}:</strong> <span class="rounded-full bg-white px-2 py-1 text-xs">{{ strtoupper($intent->status) }}</span></p>
                </div>

                <form method="POST" action="{{ route('donate.sandboxPaid', ['locale' => app()->getLocale(), 'intent' => $intent->id]) }}" class="mt-8">
                    @csrf
                    <button type="submit" class="focus-ring w-full rounded-full border border-amber-500 bg-amber-100 px-6 py-3 font-semibold text-amber-800 hover:bg-amber-200">
                        {{ __('site.donate.simulate_paid') }} (TEST)
                    </button>
                </form>
            </article>
        </div>
    </section>
@endsection
