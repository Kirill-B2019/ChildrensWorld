@extends('layouts.public')

@section('title', __('site.donate.title'))

@section('content')
    <section class="section-wrap py-16">
        <h1 class="section-title">{{ __('site.donate.title') }}</h1>
        <p class="mt-4 text-brand-muted">{{ __('site.donate.subtitle') }}</p>

        <form method="POST" action="{{ route('donate.store', ['locale' => app()->getLocale()]) }}" class="card mt-8 grid gap-4 md:grid-cols-2">
            @csrf
            <label class="text-sm font-semibold">{{ __('site.donate.amount') }}
                <input name="amount" type="number" min="100" step="1" value="1000" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
            </label>
            <label class="text-sm font-semibold">{{ __('site.donate.currency') }}
                <select name="currency" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                    <option value="KGS">KGS</option>
                    <option value="USD">USD</option>
                </select>
            </label>
            <label class="text-sm font-semibold">{{ __('site.donate.type') }}
                <select name="type" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                    <option value="one_time">{{ __('site.donate.one_time') }}</option>
                    <option value="monthly">{{ __('site.donate.monthly') }}</option>
                </select>
            </label>
            <label class="text-sm font-semibold">{{ __('site.donate.campaign') }}
                <input name="campaign" type="text" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2" placeholder="Education for Every Child">
            </label>
            <label class="text-sm font-semibold">{{ __('site.donate.name') }}
                <input name="donor_name" type="text" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
            </label>
            <label class="text-sm font-semibold">{{ __('site.donate.email') }}
                <input name="donor_email" type="email" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
            </label>
            <label class="text-sm font-semibold md:col-span-2">{{ __('site.donate.phone') }}
                <input name="donor_phone" type="text" class="mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
            </label>
            <button type="submit" class="rounded-full bg-brand-primary px-6 py-3 font-semibold text-white hover:bg-brand-primary-dark md:col-span-2">
                {{ __('site.donate.pay_qr') }}
            </button>
        </form>
    </section>
@endsection
