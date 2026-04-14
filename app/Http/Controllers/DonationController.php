<?php

namespace App\Http\Controllers;

use App\Models\DonationIntent;
use App\Models\DonationTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function create(): View
    {
        return view('pages.donate');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:100'],
            'currency' => ['required', 'in:KGS,USD'],
            'type' => ['required', 'in:one_time,monthly'],
            'campaign' => ['nullable', 'string', 'max:120'],
            'donor_name' => ['nullable', 'string', 'max:120'],
            'donor_email' => ['nullable', 'email', 'max:120'],
            'donor_phone' => ['nullable', 'string', 'max:50'],
        ]);

        $intent = DonationIntent::create([
            ...$validated,
            'locale' => app()->getLocale(),
            'status' => 'qr_generated',
            'external_reference' => 'INT-' . strtoupper(Str::random(12)),
            'idempotency_key' => (string) Str::uuid(),
            'expires_at' => now()->addMinutes(20),
        ]);

        DonationTransaction::create([
            'donation_intent_id' => $intent->id,
            'status' => 'pending',
            'payload' => [
                'merchant' => config('donation.merchant_name'),
                'bank' => config('donation.bank_name'),
                'account' => config('donation.account_kgs'),
                'purpose' => config('donation.payment_purpose'),
            ],
        ]);

        return redirect()->route('donate.show', ['locale' => app()->getLocale(), 'intent' => $intent->id]);
    }

    public function show(DonationIntent $intent): View
    {
        abort_unless($intent->locale === app()->getLocale(), 404);

        $qrPayload = implode('|', [
            'BANK=' . config('donation.bank_name'),
            'MERCHANT=' . config('donation.merchant_name'),
            'ACCOUNT=' . config('donation.account_kgs'),
            'AMOUNT=' . $intent->amount,
            'CURRENCY=' . $intent->currency,
            'REF=' . $intent->external_reference,
        ]);

        return view('pages.donate-show', compact('intent', 'qrPayload'));
    }

    public function webhook(Request $request): RedirectResponse
    {
        $signature = $request->header('X-Bank-Signature');
        $expected = hash_hmac('sha256', (string) $request->input('reference'), (string) config('donation.webhook_secret'));

        abort_unless(hash_equals($expected, (string) $signature), 403);

        $intent = DonationIntent::where('external_reference', $request->string('reference'))->firstOrFail();

        if ($intent->status === 'paid') {
            return back();
        }

        $intent->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $intent->transactions()->create([
            'status' => 'paid',
            'transaction_id' => (string) $request->input('transaction_id', 'SIM-' . Str::upper(Str::random(10))),
            'bank_reference' => (string) $request->input('bank_reference', 'BANK-' . Str::upper(Str::random(8))),
            'fee' => (float) $request->input('fee', 0),
            'payload' => $request->all(),
        ]);

        return redirect()->route('donate.success', ['locale' => app()->getLocale(), 'intent' => $intent->id]);
    }

    public function sandboxMarkPaid(DonationIntent $intent): RedirectResponse
    {
        if ($intent->status !== 'paid') {
            $intent->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $intent->transactions()->create([
                'status' => 'paid',
                'transaction_id' => 'SIM-' . Str::upper(Str::random(10)),
                'bank_reference' => 'BANK-' . Str::upper(Str::random(8)),
                'fee' => 0,
                'payload' => ['mode' => 'sandbox'],
            ]);
        }

        return redirect()->route('donate.success', ['locale' => app()->getLocale(), 'intent' => $intent->id]);
    }

    public function success(DonationIntent $intent): View
    {
        abort_unless($intent->locale === app()->getLocale(), 404);

        return view('pages.donate-success', compact('intent'));
    }
}
