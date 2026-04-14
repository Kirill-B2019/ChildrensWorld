<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/en', '/');

Route::middleware('setLocale')->group(function () {
    Route::get('/', [PublicPageController::class, 'home'])->defaults('locale', 'en')->name('home');

    Route::prefix('{locale}')
        ->whereIn('locale', ['en', 'ru', 'ky'])
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/dashboard/content')->name('admin.content.')->group(function () {
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [AdminPageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [AdminPageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
    });
});

require __DIR__.'/auth.php';
