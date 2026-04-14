<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('admin.settings.title') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.content.settings.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <label class="text-sm block"><span class="mb-1 block">{{ __('admin.settings.contact_phone') }}</span><input name="settings[contact.phone]" value="{{ old('settings.contact.phone', $settings['contact.phone'] ?? '') }}" class="w-full rounded border-gray-300"></label>
                    <label class="text-sm block"><span class="mb-1 block">{{ __('admin.settings.contact_email') }}</span><input name="settings[contact.email]" value="{{ old('settings.contact.email', $settings['contact.email'] ?? '') }}" class="w-full rounded border-gray-300"></label>
                    <label class="text-sm block"><span class="mb-1 block">{{ __('admin.settings.contact_address') }}</span><input name="settings[contact.address]" value="{{ old('settings.contact.address', $settings['contact.address'] ?? '') }}" class="w-full rounded border-gray-300"></label>
                    <label class="text-sm block"><span class="mb-1 block">{{ __('admin.settings.donation_requisites') }}</span><input name="settings[donation.requisites]" value="{{ old('settings.donation.requisites', $settings['donation.requisites'] ?? '') }}" class="w-full rounded border-gray-300"></label>
                    <label class="text-sm block"><span class="mb-1 block">{{ __('admin.settings.default_seo_description') }}</span><input name="settings[seo.default_description]" value="{{ old('settings.seo.default_description', $settings['seo.default_description'] ?? '') }}" class="w-full rounded border-gray-300"></label>
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.actions.save_settings') }}</button>
                    @if(session('status'))<p class="text-sm text-green-600">{{ session('status') }}</p>@endif
                    @if($errors->any())<p class="text-sm text-red-600">{{ $errors->first() }}</p>@endif
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
