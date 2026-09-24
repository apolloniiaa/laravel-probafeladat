<?php

use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\ContactController;
use App\Models\HeroSection;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Placeholder data until the Reference model and Filament admin exist.
    $references = [
        [
            'title' => 'Acél kényelmi eszközök',
            'date' => '2026-05-28',
            'image' => 'images/references/acel-kenyelmi-eszkozok.png',
        ],
        [
            'title' => 'Beltéri szerkezetek és térelválasztók',
            'date' => '2026-05-14',
            'image' => 'images/references/belteri-szerkezetek.png',
        ],
        [
            'title' => 'Kültéri építészeti megoldások',
            'date' => '2026-04-30',
            'image' => 'images/references/kulteri-epiteszeti-megoldasok.png',
        ],
        [
            'title' => 'Egyedi fémszerkezetek',
            'date' => '2026-04-12',
            'image' => 'images/references/egyedi-femszerkezetek.png',
        ],
    ];

    return view('home', [
        'hero' => HeroSection::current(),
        'references' => $references,
    ]);
})->name('home');

Route::post('/kapcsolat', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::prefix('admin')->name('admin.')->middleware('auth.basic')->group(function () {
    Route::get('hero', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::put('hero', [HeroSectionController::class, 'update'])->name('hero.update');
});
