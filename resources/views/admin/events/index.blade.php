<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Events</h2>
            <a href="{{ route('admin.content.events.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Create event</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full text-sm">
                    <thead><tr class="border-b"><th class="py-2 text-left">Slug</th><th class="py-2 text-left">Date</th><th class="py-2 text-left">Status</th><th class="py-2 text-left">Action</th></tr></thead>
                    <tbody>
                    @forelse($events as $event)
                        <tr class="border-b">
                            <td class="py-2">{{ $event->slug }}</td>
                            <td class="py-2">{{ optional($event->event_date)->format('Y-m-d H:i') ?? '-' }}</td>
                            <td class="py-2">{{ $event->status }}</td>
                            <td class="py-2"><a class="text-indigo-600" href="{{ route('admin.content.events.edit', $event) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-3 text-gray-500">No events yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
