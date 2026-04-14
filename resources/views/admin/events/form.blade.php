<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->exists ? 'Edit event' : 'Create event' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ $action }}" class="space-y-6">
                    @csrf
                    @if($method === 'PUT') @method('PUT') @endif

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="text-sm"><span class="mb-1 block">Slug</span><input name="slug" value="{{ old('slug', $event->slug) }}" class="w-full rounded border-gray-300"></label>
                        <label class="text-sm"><span class="mb-1 block">Status</span><select name="status" class="w-full rounded border-gray-300"><option value="draft" @selected(old('status', $event->status)==='draft')>draft</option><option value="published" @selected(old('status', $event->status)==='published')>published</option></select></label>
                        <label class="text-sm"><span class="mb-1 block">Event date</span><input type="datetime-local" name="event_date" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d\TH:i')) }}" class="w-full rounded border-gray-300"></label>
                        <label class="text-sm"><span class="mb-1 block">Location</span><input name="location" value="{{ old('location', $event->location) }}" class="w-full rounded border-gray-300"></label>
                    </div>

                    @foreach(['en','ru','kg'] as $locale)
                        <fieldset class="rounded border p-4">
                            <legend class="px-2 font-semibold uppercase">{{ $locale }}</legend>
                            <div class="grid gap-4">
                                <label class="text-sm"><span class="mb-1 block">Title</span><input name="translations[{{ $locale }}][title]" value="{{ old("translations.$locale.title", $translations[$locale]['title']) }}" class="w-full rounded border-gray-300"></label>
                                <label class="text-sm"><span class="mb-1 block">Description</span><textarea name="translations[{{ $locale }}][text]" rows="4" class="w-full rounded border-gray-300">{{ old("translations.$locale.text", $translations[$locale]['text']) }}</textarea></label>
                            </div>
                        </fieldset>
                    @endforeach

                    @if($errors->any())<div class="rounded bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>@endif
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
