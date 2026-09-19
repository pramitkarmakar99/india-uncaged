<?php
use App\\Http\\Controllers\\PublicSiteController;
use Illuminate\\Support\\Facades\\Route;

Route::get('/', [PublicSiteController::class,'home'])->name('home');
Route::get('/destinations', [PublicSiteController::class,'destinations'])->name('destinations');
Route::get('/tours', [PublicSiteController::class,'tours'])->name('tours');
Route::view('/gallery', 'gallery')->name('gallery');
Route::view('/journal', 'journal.index')->name('journal');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/plan-your-journey', 'plan')->name('plan');
