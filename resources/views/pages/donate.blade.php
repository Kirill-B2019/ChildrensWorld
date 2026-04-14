@extends('layouts.public')

@section('title', __('site.donate.title'))

@section('content')
    <section class="section-wrap section-block">
        <h1 class="section-title">{{ __('site.donate.title') }}</h1>
        <p class="mt-4 text-brand-muted">{{ __('site.donate.subtitle') }}</p>

        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            <form method="POST" action="{{ route('donate.store', ['locale' => app()->getLocale()]) }}" class="card lg:col-span-2">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="amount" class="text-sm font-semibold">{{ __('site.donate.amount') }}</label>
                        <input id="amount" name="amount" type="number" min="100" step="1" value="{{ old('amount', 1000) }}" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2 @error('amount') border-red-500 @enderror" aria-invalid="@error('amount')true @else false @enderror">
                        @error('amount')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="currency" class="text-sm font-semibold">{{ __('site.donate.currency') }}</label>
                        <select id="currency" name="currency" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                            <option value="KGS" @selected(old('currency') === 'KGS')>KGS</option>
                            <option value="USD" @selected(old('currency') === 'USD')>USD</option>
                        </select>
                    </div>
                    <div>
                        <label for="type" class="text-sm font-semibold">{{ __('site.donate.type') }}</label>
                        <select id="type" name="type" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                            <option value="one_time" @selected(old('type', 'one_time') === 'one_time')>{{ __('site.donate.one_time') }}</option>
                            <option value="monthly" @selected(old('type') === 'monthly')>{{ __('site.donate.monthly') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="campaign" class="text-sm font-semibold">{{ __('site.donate.campaign') }}</label>
                        <input id="campaign" name="campaign" type="text" value="{{ old('campaign') }}" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2" placeholder="Education for Every Child">
                    </div>
                    <div>
                        <label for="donor_name" class="text-sm font-semibold">{{ __('site.donate.name') }}</label>
                        <input id="donor_name" name="donor_name" type="text" value="{{ old('donor_name') }}" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                    </div>
                    <div>
                        <label for="donor_email" class="text-sm font-semibold">{{ __('site.donate.email') }}</label>
                        <input id="donor_email" name="donor_email" type="email" value="{{ old('donor_email') }}" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2 @error('donor_email') border-red-500 @enderror" aria-invalid="@error('donor_email')true @else false @enderror">
                        @error('donor_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="donor_phone" class="text-sm font-semibold">{{ __('site.donate.phone') }}</label>
                        <input id="donor_phone" name="donor_phone" type="text" value="{{ old('donor_phone') }}" class="focus-ring mt-2 w-full rounded-xl border border-brand-border px-3 py-2">
                    </div>
                </div>
                <button type="submit" class="focus-ring btn-primary mt-6 w-full">
                    {{ __('site.donate.pay_qr') }}
                </button>
            </form>

            <aside class="card">
                <h2 class="font-display text-xl font-semibold">Donation trust</h2>
                <ul class="mt-4 space-y-3 text-sm text-brand-muted">
                    <li>Minimum amount: {{ config('donation.minimum_amount') }} KGS</li>
                    <li>Merchant: {{ config('donation.merchant_name') }}</li>
                    <li>Bank: {{ config('donation.bank_name') }}</li>
                    <li>Account: {{ config('donation.account_kgs') }}</li>
                </ul>
                <p class="mt-4 rounded-xl bg-brand-bg p-3 text-xs text-brand-muted">
                    The payment flow is protected by bank-side confirmation and server-side signature verification.
                </p>
            </aside>
        </div>
    </section>
@endsection
