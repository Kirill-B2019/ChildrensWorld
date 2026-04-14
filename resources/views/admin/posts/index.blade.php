<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('admin.posts.title') }}</h2>
            <a href="{{ route('admin.content.posts.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.actions.create_post') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full text-sm">
                    <thead><tr class="border-b"><th class="py-2 text-left">{{ __('admin.fields.slug') }}</th><th class="py-2 text-left">{{ __('admin.fields.status') }}</th><th class="py-2 text-left">{{ __('admin.fields.en_title') }}</th><th class="py-2 text-left">{{ __('admin.fields.action') }}</th></tr></thead>
                    <tbody>
                    @forelse($posts as $post)
                        <tr class="border-b">
                            <td class="py-2">{{ $post->slug }}</td>
                            <td class="py-2">{{ $post->status }}</td>
                            <td class="py-2">{{ optional($post->translations->firstWhere('locale','en'))->title }}</td>
                            <td class="py-2"><a class="text-indigo-600" href="{{ route('admin.content.posts.edit', $post) }}">{{ __('admin.actions.edit') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-3 text-gray-500">{{ __('admin.posts.no_items') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
