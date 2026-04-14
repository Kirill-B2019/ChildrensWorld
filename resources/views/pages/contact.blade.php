@extends('layouts.public')

@section('title', __('site.nav.contact'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.contact.title') }}</h1>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <article class="card">
                <h2 class="font-display text-xl font-semibold">{{ __('site.contact.head_office') }}</h2>
                <p class="mt-3 text-brand-muted">{{ __('site.contact.address') }}</p>
                <p class="mt-2 text-brand-muted">{{ __('site.contact.phone') }}</p>
                <p class="mt-2 text-brand-muted">{{ __('site.contact.email') }}</p>
            </article>
            <article class="card">
                <h2 class="font-display text-xl font-semibold">{{ __('site.contact.requisites') }}</h2>
                <p class="mt-3 text-sm text-brand-muted">{{ config('donation.merchant_name') }}</p>
                <p class="mt-2 text-sm text-brand-muted">INN: {{ config('donation.merchant_inn') }}</p>
                <p class="mt-2 text-sm text-brand-muted">{{ config('donation.bank_name') }}, BIC {{ config('donation.bank_bic') }}</p>
                <p class="mt-2 text-sm text-brand-muted">{{ config('donation.account_kgs') }}</p>
            </article>
        </div>
    </section>
@endsection
