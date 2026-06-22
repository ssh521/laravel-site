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
            ['label' => 'Overview', 'url' => '#overview'],
            ['label' => 'Install', 'url' => '#install'],
            ['label' => 'Generated Files', 'url' => '#extend'],
            ['label' => 'Designs', 'url' => '#designs'],
        ],
        'footer' => [
            ['label' => 'Overview', 'url' => '#overview'],
            ['label' => 'Install', 'url' => '#install'],
            ['label' => 'Generated Files', 'url' => '#extend'],
            ['label' => 'Designs', 'url' => '#designs'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'brand' => [
        'name' => env('APP_NAME', 'Laravel Site'),
        'tagline' => 'Public site scaffold for Laravel Starter Kit apps.',
        'logo_text' => 'Laravel Site',
    ],

    /*
    |--------------------------------------------------------------------------
    | Design Preset
    |--------------------------------------------------------------------------
    |
    | The generated CSS ships with package-guide plus customer-site token sets.
    | The layout root receives this preset name as a class.
    |
    */
    'design' => [
        'preset' => env('LARAVEL_SITE_PRESET', 'package-guide'),
    ],
];
