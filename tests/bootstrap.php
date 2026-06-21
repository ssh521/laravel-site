<?php

$autoloaders = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../../../adminTest/vendor/autoload.php',
];

foreach ($autoloaders as $autoloader) {
    if (file_exists($autoloader)) {
        require $autoloader;

        break;
    }
}

spl_autoload_register(function (string $class): void {
    $prefixes = [
        'Ssh521\\LaravelSite\\Tests\\' => __DIR__.'/',
        'Ssh521\\LaravelSite\\' => __DIR__.'/../src/',
    ];

    foreach ($prefixes as $prefix => $basePath) {
        if (! str_starts_with($class, $prefix)) {
            continue;
        }

        $relativeClass = substr($class, strlen($prefix));
        $path = $basePath.str_replace('\\', '/', $relativeClass).'.php';

        if (file_exists($path)) {
            require $path;
        }
    }
});
