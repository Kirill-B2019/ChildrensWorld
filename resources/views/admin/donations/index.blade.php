<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donations operations</h2>
            <a href="{{ route('admin.content.donations.export', request()->query()) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Export CSV</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded bg-white p-4 shadow-sm"><p class="text-xs text-gray-500">Total intents</p><p class="text-2xl font-semibold">{{ $kpi['count'] }}</p></div>
                <div class="rounded bg-white p-4 shadow-sm"><p class="text-xs text-gray-500">Paid intents</p><p class="text-2xl font-semibold">{{ $kpi['paid_count'] }}</p></div>
                <div class="rounded bg-white p-4 shadow-sm"><p class="text-xs text-gray-500">Paid amount</p><p class="text-2xl font-semibold">{{ number_format($kpi['paid_amount'], 2) }}</p></div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form class="mb-4 grid gap-3 md:grid-cols-5">
                    <input name="status" placeholder="status" value="{{ request('status') }}" class="rounded border-gray-300">
                    <input type="date" name="from" value="{{ request('from') }}" class="rounded border-gray-300">
                    <input type="date" name="to" value="{{ request('to') }}" class="rounded border-gray-300">
                    <input type="number" step="0.01" name="min_amount" placeholder="min amount" value="{{ request('min_amount') }}" class="rounded border-gray-300">
                    <button class="rounded bg-gray-900 px-3 py-2 text-white">Filter</button>
                </form>

                <table class="min-w-full text-sm">
                    <thead><tr class="border-b"><th class="py-2 text-left">Reference</th><th class="py-2 text-left">Amount</th><th class="py-2 text-left">Status</th><th class="py-2 text-left">Created</th><th class="py-2 text-left">Action</th></tr></thead>
                    <tbody>
                    @forelse($intents as $intent)
                        <tr class="border-b">
                            <td class="py-2">{{ $intent->external_reference }}</td>
                            <td class="py-2">{{ $intent->amount }} {{ $intent->currency }}</td>
                            <td class="py-2">{{ $intent->status }}</td>
                            <td class="py-2">{{ $intent->created_at }}</td>
                            <td class="py-2"><a class="text-indigo-600" href="{{ route('admin.content.donations.show', $intent) }}">Details</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-3 text-gray-500">No donations found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $intents->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
