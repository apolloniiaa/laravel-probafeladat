<?php

use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\ContactController;
use App\Models\HeroSection;
use App\Models\Reference;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home', [
    'hero' => HeroSection::current(),
    'references' => Reference::query()->newestFirst()->get(),
]))->name('home');

Route::post('/kapcsolat', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::prefix('admin')->name('admin.')->middleware('auth.basic')->group(function () {
    Route::get('hero', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::put('hero', [HeroSectionController::class, 'update'])->name('hero.update');
    Route::resource('references', ReferenceController::class)->except('show');
});
