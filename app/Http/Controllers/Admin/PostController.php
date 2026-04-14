<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('translations')->latest()->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.form', $this->formData(new Post(['status' => 'draft'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        $post = Post::create([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($post, $data['translations']);

        return redirect()->route('admin.content.posts.index');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', $this->formData($post->load('translations')));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatePayload($request, $post->id);

        $post->update([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($post->published_at ?? now()) : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($post, $data['translations']);

        return redirect()->route('admin.content.posts.index');
    }

    private function formData(Post $post): array
    {
        $translations = [];
        foreach (['en', 'ru', 'kg'] as $locale) {
            $t = $post->translations?->firstWhere('locale', $locale);
            $translations[$locale] = [
                'title' => $t?->title ?? '',
                'excerpt' => $t?->excerpt ?? '',
                'body' => $t?->body ?? '',
            ];
        }

        return [
            'post' => $post,
            'translations' => $translations,
            'action' => $post->exists ? route('admin.content.posts.update', $post) : route('admin.content.posts.store'),
            'method' => $post->exists ? 'PUT' : 'POST',
        ];
    }

    private function syncTranslations(Post $post, array $translations): void
    {
        foreach ($translations as $locale => $translation) {
            $post->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $translation['title'],
                    'excerpt' => $translation['excerpt'] ?: null,
                    'body' => $translation['body'] ?: null,
                ]
            );
        }
    }

    private function validatePayload(Request $request, ?int $postId = null): array
    {
        return $request->validate([
            'slug' => ['required', 'string', 'max:120', 'unique:posts,slug,' . ($postId ?? 'NULL') . ',id'],
            'status' => ['required', 'in:draft,published'],
            'translations.en.title' => ['required', 'string', 'max:255'],
            'translations.ru.title' => ['required', 'string', 'max:255'],
            'translations.kg.title' => ['required', 'string', 'max:255'],
            'translations.en.excerpt' => ['nullable', 'string', 'max:255'],
            'translations.ru.excerpt' => ['nullable', 'string', 'max:255'],
            'translations.kg.excerpt' => ['nullable', 'string', 'max:255'],
            'translations.en.body' => ['nullable', 'string'],
            'translations.ru.body' => ['nullable', 'string'],
            'translations.kg.body' => ['nullable', 'string'],
        ]);
    }
}
