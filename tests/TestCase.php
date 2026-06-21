<?php

namespace Ssh521\LaravelSite\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Ssh521\LaravelSite\LaravelSiteServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LaravelSiteServiceProvider::class,
        ];
    }
}
