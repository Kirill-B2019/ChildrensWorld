<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('admin.dashboard.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('admin.dashboard.logged_in') }}
                    <div class="mt-4">
                        <a href="{{ route('admin.content.pages.index') }}" class="text-indigo-600 underline">
                            {{ __('admin.dashboard.open_content') }}
                        </a>
                    </div>
                    @if (auth()->user()?->email === config('cms.admin_email', 'test@test.com'))
                        <div class="mt-3 grid gap-1 text-sm">
                            <a href="{{ route('admin.content.posts.index') }}" class="text-indigo-600 underline">{{ __('admin.dashboard.manage_blog') }}</a>
                            <a href="{{ route('admin.content.events.index') }}" class="text-indigo-600 underline">{{ __('admin.dashboard.manage_events') }}</a>
                            <a href="{{ route('admin.content.reports.index') }}" class="text-indigo-600 underline">{{ __('admin.dashboard.manage_reports') }}</a>
                            <a href="{{ route('admin.content.donations.index') }}" class="text-indigo-600 underline">{{ __('admin.dashboard.manage_donations') }}</a>
                            <a href="{{ route('admin.content.settings.edit') }}" class="text-indigo-600 underline">{{ __('admin.dashboard.manage_settings') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
