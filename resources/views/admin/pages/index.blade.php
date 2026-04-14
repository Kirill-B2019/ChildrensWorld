<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Content Pages
            </h2>
            <a href="{{ route('admin.content.pages.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                Create page
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Slug</th>
                                <th class="py-2 text-left">Status</th>
                                <th class="py-2 text-left">EN Title</th>
                                <th class="py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                @php $en = $page->translations->firstWhere('locale', 'en'); @endphp
                                <tr class="border-b">
                                    <td class="py-2">{{ $page->slug }}</td>
                                    <td class="py-2">{{ $page->status }}</td>
                                    <td class="py-2">{{ $en?->title ?? '-' }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('admin.content.pages.edit', $page) }}" class="text-indigo-600">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-gray-500">No pages yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
