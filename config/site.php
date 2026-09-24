<?php

/*
|--------------------------------------------------------------------------
| Site Content
|--------------------------------------------------------------------------
|
| Site-wide content used by the header and footer. These values are good
| candidates to move into a Filament-managed settings page later on.
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

    'legal' => [
        ['label' => 'Adatvédelem', 'href' => '#'],
        ['label' => 'Impresszum', 'href' => '#'],
    ],

];
