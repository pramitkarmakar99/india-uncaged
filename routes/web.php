<?php
use App\\Http\\Controllers\\PublicSiteController;
use App\\Http\\Controllers\\AuthController;
use App\\Http\\Controllers\\Admin\\DashboardController;
use App\\Http\\Controllers\\Admin\\DestinationController;
use Illuminate\\Support\\Facades\\Route;

Route::get('/', [PublicSiteController::class,'home'])->name('home');
Route::get('/destinations', [PublicSiteController::class,'destinations'])->name('destinations');
Route::get('/tours', [PublicSiteController::class,'tours'])->name('tours');
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
});
