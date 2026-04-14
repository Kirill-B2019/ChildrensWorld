<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class PublicPageController extends Controller
{
    public function home(): View
    {
        $homePage = null;
        if (Schema::hasTable('pages')) {
            $homePage = Page::with('translations')
                ->where('slug', 'home')
                ->where('status', 'published')
                ->first();
        }

        $homeTranslation = $homePage?->translationFor(app()->getLocale());

        $stats = [
            ['value' => '12+', 'label' => __('site.stats.years')],
            ['value' => '2,500+', 'label' => __('site.stats.children')],
            ['value' => '48', 'label' => __('site.stats.schools')],
            ['value' => '7', 'label' => __('site.stats.regions')],
        ];

        $programs = [
            ['title' => __('site.programs.items.kits.title'), 'raised' => '18,000', 'goal' => '30,000'],
            ['title' => __('site.programs.items.scholarships.title'), 'raised' => '19,000', 'goal' => '30,000'],
            ['title' => __('site.programs.items.digital.title'), 'raised' => '13,000', 'goal' => '24,000'],
            ['title' => __('site.programs.items.teachers.title'), 'raised' => '12,000', 'goal' => '17,000'],
        ];

        return view('pages.home', compact('stats', 'programs', 'homeTranslation'));
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function programs(): View
    {
        return view('pages.programs');
    }

    public function children(): View
    {
        return view('pages.children');
    }

    public function events(): View
    {
        return view('pages.events');
    }

    public function blog(): View
    {
        return view('pages.blog');
    }

    public function reports(): View
    {
        return view('pages.reports');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function faq(): View
    {
        return view('pages.faq');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }
}
