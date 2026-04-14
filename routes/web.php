<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/en', '/');
Route::redirect('/ky', '/kg');

Route::middleware('setLocale')->group(function () {
    Route::get('/', [PublicPageController::class, 'home'])->defaults('locale', 'en')->name('home');

    Route::prefix('{locale}')
        ->whereIn('locale', ['en', 'ru', 'kg'])
        ->group(function () {
            Route::get('/', [PublicPageController::class, 'home'])->name('home.localized');
            Route::get('/about', [PublicPageController::class, 'about'])->name('about');
            Route::get('/programs', [PublicPageController::class, 'programs'])->name('programs');
            Route::get('/children', [PublicPageController::class, 'children'])->name('children');
            Route::get('/events', [PublicPageController::class, 'events'])->name('events');
            Route::get('/blog', [PublicPageController::class, 'blog'])->name('blog');
            Route::get('/reports', [PublicPageController::class, 'reports'])->name('reports');
            Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
            Route::get('/faq', [PublicPageController::class, 'faq'])->name('faq');
            Route::get('/privacy', [PublicPageController::class, 'privacy'])->name('privacy');
            Route::get('/terms', [PublicPageController::class, 'terms'])->name('terms');

            Route::get('/donate', [DonationController::class, 'create'])->name('donate');
            Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
            Route::get('/donate/{intent}', [DonationController::class, 'show'])->name('donate.show');
            Route::post('/donate/{intent}/sandbox-paid', [DonationController::class, 'sandboxMarkPaid'])->name('donate.sandboxPaid');
            Route::get('/donate/{intent}/success', [DonationController::class, 'success'])->name('donate.success');
        });
});

Route::post('/bank/qr/webhook', [DonationController::class, 'webhook'])->name('donate.webhook');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/locale/{locale}', function (string $locale) {
        abort_unless(in_array($locale, ['en', 'ru', 'kg'], true), 404);
        session(['dashboard_locale' => $locale]);

        return back();
    })->name('dashboard.locale');
});

Route::middleware('auth')->middleware('dashboardLocale')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->prefix('/dashboard/content')->name('admin.content.')->group(function () {
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [AdminPageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

        Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');

        Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [AdminEventController::class, 'create'])->name('events.create');
        Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [AdminEventController::class, 'update'])->name('events.update');

        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/create', [AdminReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [AdminReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}/edit', [AdminReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{report}', [AdminReportController::class, 'update'])->name('reports.update');

        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('/donations/export.csv', [AdminDonationController::class, 'exportCsv'])->name('donations.export');
        Route::get('/donations/{intent}', [AdminDonationController::class, 'show'])->name('donations.show');
        Route::patch('/donations/{intent}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.status');

        Route::get('/settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
