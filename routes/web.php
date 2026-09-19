<?php

use Illuminate\\Support\\Facades\\Route;

Route::view('/', 'home')->name('home');
Route::view('/destinations', 'destinations.index')->name('destinations');
Route::view('/tours', 'tours.index')->name('tours');
Route::view('/gallery', 'gallery')->name('gallery');
Route::view('/journal', 'journal.index')->name('journal');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/plan-your-journey', 'plan')->name('plan');
