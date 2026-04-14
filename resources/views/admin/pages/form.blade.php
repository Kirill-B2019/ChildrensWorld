<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $page->exists ? __('admin.pages.edit_title') : __('admin.pages.create_title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ $action }}" class="space-y-6">
                        @csrf
                        @if($method === 'PUT')
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="text-sm">
                                <span class="block mb-1">{{ __('admin.fields.slug') }}</span>
                                <input name="slug" value="{{ old('slug', $page->slug) }}" class="w-full rounded border-gray-300">
                            </label>
                            <label class="text-sm">
                                <span class="block mb-1">{{ __('admin.fields.template') }}</span>
                                <input name="template" value="{{ old('template', $page->template) }}" class="w-full rounded border-gray-300">
                            </label>
                            <label class="text-sm">
                                <span class="block mb-1">{{ __('admin.fields.status') }}</span>
                                <select name="status" class="w-full rounded border-gray-300">
                                    <option value="draft" @selected(old('status', $page->status) === 'draft')>{{ __('admin.fields.draft') }}</option>
                                    <option value="published" @selected(old('status', $page->status) === 'published')>{{ __('admin.fields.published') }}</option>
                                </select>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ str_replace(':slug', old('slug', $page->slug ?: 'your-page-slug'), __('admin.pages.slug_preview')) }}
                        </p>

                        @foreach (['en', 'ru', 'kg'] as $locale)
                            <fieldset class="rounded border p-4">
                                <legend class="px-2 font-semibold uppercase">{{ $locale }}</legend>
                                <div class="grid gap-4">
                                    <label class="text-sm">
                                        <span class="block mb-1">{{ __('admin.fields.title') }}</span>
                                        <input name="translations[{{ $locale }}][title]" value="{{ old("translations.$locale.title", $translations[$locale]['title']) }}" class="w-full rounded border-gray-300">
                                    </label>
                                    <label class="text-sm">
                                        <span class="block mb-1">{{ __('admin.fields.meta_title') }}</span>
                                        <input name="translations[{{ $locale }}][meta_title]" value="{{ old("translations.$locale.meta_title", $translations[$locale]['meta_title']) }}" class="w-full rounded border-gray-300">
                                    </label>
                                    <label class="text-sm">
                                        <span class="block mb-1">{{ __('admin.fields.meta_description') }}</span>
                                        <input name="translations[{{ $locale }}][meta_description]" value="{{ old("translations.$locale.meta_description", $translations[$locale]['meta_description']) }}" class="w-full rounded border-gray-300">
                                    </label>
                                    <label class="text-sm">
                                        <span class="block mb-1">{{ __('admin.fields.body') }}</span>
                                        <textarea name="translations[{{ $locale }}][body]" rows="4" class="w-full rounded border-gray-300">{{ old("translations.$locale.body", $translations[$locale]['body']) }}</textarea>
                                    </label>
                                </div>
                            </fieldset>
                        @endforeach

                        @if ($errors->any())
                            <div class="rounded bg-red-50 p-3 text-sm text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                            {{ __('admin.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
