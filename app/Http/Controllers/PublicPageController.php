<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Page;
use App\Models\Report;
use App\Models\SiteSetting;
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
        $events = collect();
        if (Schema::hasTable('events') && Schema::hasTable('event_translations')) {
            $events = Event::with('translations')
                ->where('status', 'published')
                ->orderByDesc('event_date')
                ->get();
        }

        return view('pages.events', compact('events'));
    }

    public function blog(): View
    {
        $posts = collect();
        if (Schema::hasTable('posts') && Schema::hasTable('post_translations')) {
            $posts = Post::with('translations')
                ->where('status', 'published')
                ->orderByDesc('published_at')
                ->get();
        }

        return view('pages.blog', compact('posts'));
    }

    public function reports(): View
    {
        $reports = collect();
        if (Schema::hasTable('reports') && Schema::hasTable('report_translations')) {
            $reports = Report::with('translations')
                ->where('status', 'published')
                ->orderByDesc('published_at')
                ->get();
        }

        return view('pages.reports', compact('reports'));
    }

    public function contact(): View
    {
        $settings = [];
        if (Schema::hasTable('site_settings')) {
            $settings = [
                'phone' => SiteSetting::getValue('site', 'contact.phone'),
                'email' => SiteSetting::getValue('site', 'contact.email'),
                'address' => SiteSetting::getValue('site', 'contact.address'),
                'requisites' => SiteSetting::getValue('site', 'donation.requisites'),
            ];
        }

        return view('pages.contact', compact('settings'));
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
