<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('translations')->latest()->get();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.form', $this->formData(new Event(['status' => 'draft'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        $event = Event::create([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'event_date' => $data['event_date'] ?? null,
            'location' => $data['location'] ?? null,
            'published_at' => $data['status'] === 'published' ? now() : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($event, $data['translations']);

        return redirect()->route('admin.content.events.index');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', $this->formData($event->load('translations')));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validatePayload($request, $event->id);

        $event->update([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'event_date' => $data['event_date'] ?? null,
            'location' => $data['location'] ?? null,
            'published_at' => $data['status'] === 'published' ? ($event->published_at ?? now()) : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($event, $data['translations']);

        return redirect()->route('admin.content.events.index');
    }

    private function formData(Event $event): array
    {
        $translations = [];
        foreach (['en', 'ru', 'kg'] as $locale) {
            $t = $event->translations?->firstWhere('locale', $locale);
            $translations[$locale] = [
                'title' => $t?->title ?? '',
                'text' => $t?->text ?? '',
            ];
        }

        return [
            'event' => $event,
            'translations' => $translations,
            'action' => $event->exists ? route('admin.content.events.update', $event) : route('admin.content.events.store'),
            'method' => $event->exists ? 'PUT' : 'POST',
        ];
    }

    private function syncTranslations(Event $event, array $translations): void
    {
        foreach ($translations as $locale => $translation) {
            $event->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $translation['title'],
                    'text' => $translation['text'] ?: null,
                ]
            );
        }
    }

    private function validatePayload(Request $request, ?int $eventId = null): array
    {
        return $request->validate([
            'slug' => ['required', 'string', 'max:120', 'unique:events,slug,' . ($eventId ?? 'NULL') . ',id'],
            'status' => ['required', 'in:draft,published'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:120'],
            'translations.en.title' => ['required', 'string', 'max:255'],
            'translations.ru.title' => ['required', 'string', 'max:255'],
            'translations.kg.title' => ['required', 'string', 'max:255'],
            'translations.en.text' => ['nullable', 'string'],
            'translations.ru.text' => ['nullable', 'string'],
            'translations.kg.text' => ['nullable', 'string'],
        ]);
    }
}
