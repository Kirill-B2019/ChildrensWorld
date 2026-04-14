<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('admin.pages.title') }}
            </h2>
            <a href="{{ route('admin.content.pages.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                {{ __('admin.actions.create_page') }}
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
                                <th class="py-2 text-left">{{ __('admin.fields.slug') }}</th>
                                <th class="py-2 text-left">{{ __('admin.fields.status') }}</th>
                                <th class="py-2 text-left">{{ __('admin.fields.en_title') }}</th>
                                <th class="py-2 text-left">{{ __('admin.fields.published_at') }}</th>
                                <th class="py-2 text-left">{{ __('admin.fields.updated_by') }}</th>
                                <th class="py-2 text-left">{{ __('admin.fields.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                @php $en = $page->translations->firstWhere('locale', 'en'); @endphp
                                <tr class="border-b">
                                    <td class="py-2">{{ $page->slug }}</td>
                                    <td class="py-2">{{ $page->status }}</td>
                                    <td class="py-2">{{ $en?->title ?? '-' }}</td>
                                    <td class="py-2">{{ optional($page->published_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="py-2">{{ $page->editor?->email ?? '-' }}</td>
                                    <td class="py-2">
                                        <a href="{{ route('admin.content.pages.edit', $page) }}" class="text-indigo-600">{{ __('admin.actions.edit') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-gray-500">{{ __('admin.pages.no_items') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
