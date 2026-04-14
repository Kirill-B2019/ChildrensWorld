<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $report->exists ? __('admin.reports.edit_title') : __('admin.reports.create_title') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if($method === 'PUT') @method('PUT') @endif

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.slug') }}</span><input name="slug" value="{{ old('slug', $report->slug) }}" class="w-full rounded border-gray-300"></label>
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.status') }}</span><select name="status" class="w-full rounded border-gray-300"><option value="draft" @selected(old('status', $report->status)==='draft')>{{ __('admin.fields.draft') }}</option><option value="published" @selected(old('status', $report->status)==='published')>{{ __('admin.fields.published') }}</option></select></label>
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.period') }}</span><input name="period" value="{{ old('period', $report->period) }}" class="w-full rounded border-gray-300"></label>
                        <label class="text-sm"><span class="mb-1 block">{{ __('admin.fields.file') }}</span><input type="file" name="report_file" class="w-full rounded border-gray-300"></label>
                    </div>
                    @if($report->file_path)<p class="text-xs text-gray-500">{{ __('admin.reports.current_file', ['path' => $report->file_path]) }}</p>@endif

                    @foreach(['en','ru','kg'] as $locale)
                        <fieldset class="rounded border p-4">
                            <legend class="px-2 font-semibold uppercase">{{ $locale }}</legend>
                            <label class="text-sm block"><span class="mb-1 block">{{ __('admin.fields.title') }}</span><input name="translations[{{ $locale }}][title]" value="{{ old("translations.$locale.title", $translations[$locale]['title']) }}" class="w-full rounded border-gray-300"></label>
                        </fieldset>
                    @endforeach

                    @if($errors->any())<div class="rounded bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.actions.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
