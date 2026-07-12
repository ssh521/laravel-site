<?php

namespace Ssh521\LaravelSite;

use Illuminate\Support\ServiceProvider;
use Ssh521\LaravelSite\Console\Commands\DesignCommand;
use Ssh521\LaravelSite\Console\Commands\InstallCommand;
use Ssh521\LaravelSite\Support\DesignCatalog;
use Ssh521\LaravelSite\Support\DesignLibrary;

class LaravelSiteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-site.php', 'laravel-site');
        $this->app->singleton(DesignCatalog::class);
        $this->app->singleton(DesignLibrary::class);
    }

    public function boot(): void
    {
        $this->registerCommands();
        $this->registerPublishables();
    }

    private function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            DesignCommand::class,
            InstallCommand::class,
        ]);
    }

    private function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-site.php' => config_path('laravel-site.php'),
        ], 'laravel-site-config');
    }
}
