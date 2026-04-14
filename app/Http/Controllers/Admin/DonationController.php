<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationIntent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(Request $request): View
    {
        $query = DonationIntent::query()->with('transactions');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', (float) $request->input('min_amount'));
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', (float) $request->input('max_amount'));
        }

        $intents = $query->latest()->paginate(20)->withQueryString();

        $kpi = [
            'count' => DonationIntent::count(),
            'paid_count' => DonationIntent::where('status', 'paid')->count(),
            'paid_amount' => (float) DonationIntent::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.donations.index', compact('intents', 'kpi'));
    }

    public function show(DonationIntent $intent): View
    {
        $intent->load('transactions');

        return view('admin.donations.show', compact('intent'));
    }

    public function updateStatus(Request $request, DonationIntent $intent): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:created,qr_generated,paid,failed,expired'],
        ]);

        $current = $intent->status;
        $next = $data['status'];

        $allowedTransitions = [
            'created' => ['qr_generated', 'failed', 'expired'],
            'qr_generated' => ['paid', 'failed', 'expired'],
            'failed' => ['qr_generated'],
            'expired' => ['qr_generated'],
            'paid' => [],
        ];

        if (! in_array($next, $allowedTransitions[$current] ?? [], true)) {
            return back()->withErrors([
                'status' => __('admin.donations.transition_error', ['from' => $current, 'to' => $next]),
            ]);
        }

        $intent->update([
            'status' => $next,
            'paid_at' => $next === 'paid' ? now() : $intent->paid_at,
        ]);

        return redirect()->route('admin.content.donations.show', $intent);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $fileName = 'donations-' . now()->format('Ymd-His') . '.csv';
        $query = DonationIntent::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $rows = $query->get();

        return response()->streamDownload(function () use ($rows): void {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['id', 'reference', 'amount', 'currency', 'status', 'donor_email', 'created_at']);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->id,
                    $row->external_reference,
                    $row->amount,
                    $row->currency,
                    $row->status,
                    $row->donor_email,
                    $row->created_at,
                ]);
            }
            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }
}
