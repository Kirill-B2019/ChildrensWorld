<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with('translations')->latest()->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function create(): View
    {
        return view('admin.reports.form', $this->formData(new Report(['status' => 'draft'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);
        $path = $request->file('report_file')?->store('reports', 'public');

        $report = Report::create([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'period' => $data['period'] ?? null,
            'file_path' => $path,
            'published_at' => $data['status'] === 'published' ? now() : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($report, $data['translations']);

        return redirect()->route('admin.content.reports.index');
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.form', $this->formData($report->load('translations')));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $data = $this->validatePayload($request, $report->id);
        $path = $report->file_path;

        if ($request->hasFile('report_file')) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('report_file')->store('reports', 'public');
        }

        $report->update([
            'slug' => $data['slug'],
            'status' => $data['status'],
            'period' => $data['period'] ?? null,
            'file_path' => $path,
            'published_at' => $data['status'] === 'published' ? ($report->published_at ?? now()) : null,
            'updated_by' => Auth::id(),
        ]);

        $this->syncTranslations($report, $data['translations']);

        return redirect()->route('admin.content.reports.index');
    }

    private function formData(Report $report): array
    {
        $translations = [];
        foreach (['en', 'ru', 'kg'] as $locale) {
            $t = $report->translations?->firstWhere('locale', $locale);
            $translations[$locale] = ['title' => $t?->title ?? ''];
        }

        return [
            'report' => $report,
            'translations' => $translations,
            'action' => $report->exists ? route('admin.content.reports.update', $report) : route('admin.content.reports.store'),
            'method' => $report->exists ? 'PUT' : 'POST',
        ];
    }

    private function syncTranslations(Report $report, array $translations): void
    {
        foreach ($translations as $locale => $translation) {
            $report->translations()->updateOrCreate(
                ['locale' => $locale],
                ['title' => $translation['title']]
            );
        }
    }

    private function validatePayload(Request $request, ?int $reportId = null): array
    {
        return $request->validate([
            'slug' => ['required', 'string', 'max:120', 'unique:reports,slug,' . ($reportId ?? 'NULL') . ',id'],
            'status' => ['required', 'in:draft,published'],
            'period' => ['nullable', 'string', 'max:50'],
            'report_file' => [$reportId ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'translations.en.title' => ['required', 'string', 'max:255'],
            'translations.ru.title' => ['required', 'string', 'max:255'],
            'translations.kg.title' => ['required', 'string', 'max:255'],
        ]);
    }
}
