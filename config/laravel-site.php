<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public Site Route
    |--------------------------------------------------------------------------
    |
    | laravel-site:install creates routes/site.php in the host app. The home
    | path defaults to "/" so the generated landing page becomes the app's
    | public front page. Change this when the starter kit already owns root.
    |
    */
    'routes' => [
        'home_path' => env('LARAVEL_SITE_HOME_PATH', '/'),
        'home_name' => 'site.home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    |
    | Header and footer components read these arrays. Developers can keep this
    | config-driven flow or replace the generated Blade with project-specific
    | markup after install.
    |
    */
    'navigation' => [
        'header' => [
            ['label' => 'Home', 'url' => '/', 'active' => true],
            [
                'label' => 'Services',
                'url' => '#services',
                'children' => [
                    ['label' => 'Strategy', 'url' => '#strategy'],
                    ['label' => 'Design', 'url' => '#design'],
                    ['label' => 'Development', 'url' => '#development'],
                ],
            ],
            ['label' => 'Work', 'url' => '#work'],
            ['label' => 'Contact', 'url' => '#contact'],
        ],
        'footer' => [
            ['label' => 'Company', 'url' => '#about'],
            ['label' => 'Services', 'url' => '#services'],
            ['label' => 'Contact', 'url' => '#contact'],
            ['label' => 'Privacy', 'url' => '/privacy'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'brand' => [
        'name' => env('APP_NAME', 'Laravel Site'),
        'tagline' => 'Fast, responsive customer websites for Laravel.',
        'logo_text' => env('APP_NAME', 'Site'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Design Preset
    |--------------------------------------------------------------------------
    |
    | The generated CSS ships with essential, editorial, and conversion token
    | sets. The layout root receives this preset name as a class.
    |
    */
    'design' => [
        'preset' => env('LARAVEL_SITE_PRESET', 'essential'),
    ],
];
