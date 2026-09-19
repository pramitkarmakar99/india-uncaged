<?php
use App\\Http\\Controllers\\PublicSiteController;
use App\\Http\\Controllers\\AuthController;
use App\\Http\\Controllers\\Admin\\DashboardController;
use App\\Http\\Controllers\\Admin\\DestinationController;
use App\\Http\\Controllers\\Admin\\TourController;
use App\\Http\\Controllers\\Admin\\TourDateController;
use Illuminate\\Support\\Facades\\Route;

Route::get('/', [PublicSiteController::class,'home'])->name('home');
Route::get('/destinations', [PublicSiteController::class,'destinations'])->name('destinations');
Route::get('/destinations/{destination:slug}', [PublicSiteController::class,'destination'])->name('destinations.show');
Route::get('/tours', [PublicSiteController::class,'tours'])->name('tours');
Route::get('/tours/{tour:slug}', [PublicSiteController::class,'tour'])->name('tours.show');
Route::view('/gallery', 'gallery')->name('gallery');
Route::view('/journal', 'journal.index')->name('journal');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/plan-your-journey', 'plan')->name('plan');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('destinations', DestinationController::class)->except(['show']);
    Route::patch('/destinations/{destination}/archive', [DestinationController::class, 'archive'])->name('destinations.archive');
    Route::resource('tours', TourController::class)->except(['show']);
    Route::patch('/tours/{tour}/archive', [TourController::class, 'archive'])->name('tours.archive');
    Route::resource('tour-dates', TourDateController::class)->except(['show']);
});
