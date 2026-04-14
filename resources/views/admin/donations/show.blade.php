<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('admin.donations.single_title', ['reference' => $intent->external_reference]) }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p><strong>{{ __('admin.donations.amount') }}:</strong> {{ $intent->amount }} {{ $intent->currency }}</p>
                <p><strong>{{ __('admin.donations.status') }}:</strong> {{ $intent->status }}</p>
                <p><strong>{{ __('admin.donations.donor') }}:</strong> {{ $intent->donor_name ?: '-' }} / {{ $intent->donor_email ?: '-' }}</p>
                <form method="POST" action="{{ route('admin.content.donations.status', $intent) }}" class="mt-4 flex items-center gap-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rounded border-gray-300">
                        @foreach(['created','qr_generated','paid','failed','expired'] as $status)
                            <option value="{{ $status }}" @selected($intent->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.actions.update_status') }}</button>
                </form>
                @if($errors->any())<p class="mt-2 text-sm text-red-600">{{ $errors->first() }}</p>@endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">{{ __('admin.donations.transactions') }}</h3>
                <div class="mt-4 space-y-4">
                    @forelse($intent->transactions as $tx)
                        <article class="rounded border p-3">
                            <p><strong>{{ __('admin.donations.status') }}:</strong> {{ $tx->status }} | <strong>TX:</strong> {{ $tx->transaction_id ?: '-' }}</p>
                            <pre class="mt-2 overflow-auto rounded bg-gray-100 p-2 text-xs">{{ json_encode($tx->payload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('admin.donations.no_transactions') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
