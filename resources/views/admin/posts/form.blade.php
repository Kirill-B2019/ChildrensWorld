<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->exists ? __('admin.posts.edit_title') : __('admin.posts.create_title') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ $action }}" class="space-y-6">
                    @csrf
                    @if($method === 'PUT') @method('PUT') @endif

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.slug') }}</span><input name="slug" value="{{ old('slug', $post->slug) }}" class="w-full rounded border-gray-300"></label>
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.status') }}</span><select name="status" class="w-full rounded border-gray-300"><option value="draft" @selected(old('status', $post->status)==='draft')>{{ __('admin.fields.draft') }}</option><option value="published" @selected(old('status', $post->status)==='published')>{{ __('admin.fields.published') }}</option></select></label>
                    </div>

                    @foreach(['en','ru','kg'] as $locale)
                        <fieldset class="rounded border p-4">
                            <legend class="px-2 font-semibold uppercase">{{ $locale }}</legend>
                            <div class="grid gap-4">
                                <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.title') }}</span><input name="translations[{{ $locale }}][title]" value="{{ old("translations.$locale.title", $translations[$locale]['title']) }}" class="w-full rounded border-gray-300"></label>
                                <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.excerpt') }}</span><input name="translations[{{ $locale }}][excerpt]" value="{{ old("translations.$locale.excerpt", $translations[$locale]['excerpt']) }}" class="w-full rounded border-gray-300"></label>
                                <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.body') }}</span><textarea name="translations[{{ $locale }}][body]" rows="4" class="w-full rounded border-gray-300">{{ old("translations.$locale.body", $translations[$locale]['body']) }}</textarea></label>
                            </div>
                        </fieldset>
                    @endforeach

                    @if($errors->any())<div class="rounded bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.actions.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
