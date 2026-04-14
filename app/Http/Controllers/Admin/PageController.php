<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::with(['translations', 'editor'])->orderByDesc('updated_at')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.form', [
            'page' => new Page(['template' => 'default', 'status' => 'draft']),
            'translations' => [
                'en' => ['title' => '', 'meta_title' => '', 'meta_description' => '', 'body' => ''],
                'ru' => ['title' => '', 'meta_title' => '', 'meta_description' => '', 'body' => ''],
                'kg' => ['title' => '', 'meta_title' => '', 'meta_description' => '', 'body' => ''],
            ],
            'action' => route('admin.content.pages.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        $page = Page::create([
            'slug' => $data['slug'],
            'template' => $data['template'],
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
            'updated_by' => Auth::id(),
        ]);

        foreach ($data['translations'] as $locale => $translation) {
            $page->translations()->create([
                'locale' => $locale,
                'title' => $translation['title'],
                'meta_title' => $translation['meta_title'] ?: null,
                'meta_description' => $translation['meta_description'] ?: null,
                'body' => $translation['body'] ?: null,
            ]);
        }

        return redirect()->route('admin.content.pages.index');
    }

    public function edit(Page $page): View
    {
        $page->load('translations');

        $translations = [];
        foreach (['en', 'ru', 'kg'] as $locale) {
            $t = $page->translations->firstWhere('locale', $locale);
            $translations[$locale] = [
                'title' => $t?->title ?? '',
                'meta_title' => $t?->meta_title ?? '',
                'meta_description' => $t?->meta_description ?? '',
                'body' => $t?->body ?? '',
            ];
        }

        return view('admin.pages.form', [
            'page' => $page,
            'translations' => $translations,
            'action' => route('admin.content.pages.update', $page),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validatePayload($request, $page->id);

        $page->update([
            'slug' => $data['slug'],
            'template' => $data['template'],
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($page->published_at ?? now()) : null,
            'updated_by' => Auth::id(),
        ]);

        foreach ($data['translations'] as $locale => $translation) {
            $page->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $translation['title'],
                    'meta_title' => $translation['meta_title'] ?: null,
                    'meta_description' => $translation['meta_description'] ?: null,
                    'body' => $translation['body'] ?: null,
                ]
            );
        }

        return redirect()->route('admin.content.pages.index');
    }

    private function validatePayload(Request $request, ?int $pageId = null): array
    {
        return $request->validate([
            'slug' => ['required', 'string', 'max:120', 'unique:pages,slug,' . ($pageId ?? 'NULL') . ',id'],
            'template' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:draft,published'],
            'translations.en.title' => ['required', 'string', 'max:255'],
            'translations.ru.title' => ['required', 'string', 'max:255'],
            'translations.kg.title' => ['required', 'string', 'max:255'],
            'translations.en.meta_title' => ['nullable', 'string', 'max:255'],
            'translations.ru.meta_title' => ['nullable', 'string', 'max:255'],
            'translations.kg.meta_title' => ['nullable', 'string', 'max:255'],
            'translations.en.meta_description' => ['nullable', 'string', 'max:255'],
            'translations.ru.meta_description' => ['nullable', 'string', 'max:255'],
            'translations.kg.meta_description' => ['nullable', 'string', 'max:255'],
            'translations.en.body' => ['nullable', 'string'],
            'translations.ru.body' => ['nullable', 'string'],
            'translations.kg.body' => ['nullable', 'string'],
        ]);
    }
}
