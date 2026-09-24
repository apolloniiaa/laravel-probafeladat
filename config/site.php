<?php

/*
|--------------------------------------------------------------------------
| Site Content
|--------------------------------------------------------------------------
|
| Site-wide content for the landing page. The references are shown as a
| fallback while no references have been added in the admin.
|
*/

return [

    'name' => 'FÉM Stúdió',

    'tagline' => 'Ipari formatervező stúdió Budapesten.',

    'navigation' => [
        ['label' => 'Munkáink', 'href' => '#munkaink'],
        ['label' => 'Stúdió', 'href' => '#'],
        ['label' => 'Folyamat', 'href' => '#'],
    ],

    'contact' => [
        'address' => '1061 Budapest Fém utca 99.',
        'email' => 'studio@fem.hu',
        'phone' => '+36 1 234 5678',
    ],

    'references' => [
        ['title' => 'Acél kényelmi eszközök', 'date' => '2026-05-28', 'image' => 'images/references/acel-kenyelmi-eszkozok.png'],
        ['title' => 'Beltéri szerkezetek és térelválasztók', 'date' => '2026-05-14', 'image' => 'images/references/belteri-szerkezetek.png'],
        ['title' => 'Kültéri építészeti megoldások', 'date' => '2026-04-30', 'image' => 'images/references/kulteri-epiteszeti-megoldasok.png'],
        ['title' => 'Egyedi fémszerkezetek', 'date' => '2026-04-12', 'image' => 'images/references/egyedi-femszerkezetek.png'],
    ],

    'legal' => [
        ['label' => 'Adatvédelem', 'href' => '#'],
        ['label' => 'Impresszum', 'href' => '#'],
    ],

];
