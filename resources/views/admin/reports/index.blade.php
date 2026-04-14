<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
            <a href="{{ route('admin.content.reports.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Create report</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full text-sm">
                    <thead><tr class="border-b"><th class="py-2 text-left">Slug</th><th class="py-2 text-left">Period</th><th class="py-2 text-left">File</th><th class="py-2 text-left">Status</th><th class="py-2 text-left">Action</th></tr></thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr class="border-b">
                            <td class="py-2">{{ $report->slug }}</td>
                            <td class="py-2">{{ $report->period ?? '-' }}</td>
                            <td class="py-2">@if($report->file_path)<a class="text-indigo-600" href="{{ asset('storage/'.$report->file_path) }}" target="_blank">Open</a>@else - @endif</td>
                            <td class="py-2">{{ $report->status }}</td>
                            <td class="py-2"><a class="text-indigo-600" href="{{ route('admin.content.reports.edit', $report) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-3 text-gray-500">No reports yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
