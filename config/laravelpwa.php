<?php

return [
    'name' => 'Contábil',
    'manifest' => [
        'name' => env('APP_NAME', 'Contábil'),
        'short_name' => 'Contábil',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/190.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/256.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/512.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Contabil',
                'description' => 'Sistema contábil',
                'url' => 'https://contabil.f-softsistemas.com.br',
                'icons' => [
                    "src" => "/images/icons/72.png",
                    "purpose" => "any"
                ]
            ],
        ],
        'custom' => []
    ]
];
