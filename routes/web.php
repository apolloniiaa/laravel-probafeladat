<?php

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

    return view('home', ['references' => $references]);
})->name('home');
