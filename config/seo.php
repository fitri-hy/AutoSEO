<?php

return [
    'site' => [
        'name' => env('APP_NAME'),
        'url' => env('APP_URL'),
        'logo' => '/logo.png',
        'locales' => ['id', 'en'],
    ],

    'default' => [
        'title' => env('APP_NAME'),
        'description' => '',
        'robots' => 'index,follow',
        'canonical' => null,
        'og_type' => 'website',
        'og_image' => '/logo.png',
        'twitter_card' => 'summary_large_image',
    ],
];
