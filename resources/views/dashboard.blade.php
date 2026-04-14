<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <div class="mt-4">
                        <a href="{{ route('admin.content.pages.index') }}" class="text-indigo-600 underline">
                            Open content management
                        </a>
                    </div>
                    @if (auth()->user()?->email === env('ADMIN_EMAIL', 'test@test.com'))
                        <div class="mt-3 grid gap-1 text-sm">
                            <a href="{{ route('admin.content.posts.index') }}" class="text-indigo-600 underline">Manage blog</a>
                            <a href="{{ route('admin.content.events.index') }}" class="text-indigo-600 underline">Manage events</a>
                            <a href="{{ route('admin.content.reports.index') }}" class="text-indigo-600 underline">Manage reports</a>
                            <a href="{{ route('admin.content.donations.index') }}" class="text-indigo-600 underline">Donations operations</a>
                            <a href="{{ route('admin.content.settings.edit') }}" class="text-indigo-600 underline">Global settings</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
