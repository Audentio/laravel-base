<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\MigrationServiceProvider as BaseMigrationServiceProvider;

class MigrationServiceProvider extends BaseMigrationServiceProvider implements DeferrableProvider
{
    protected function registerCreator()
    {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files'], $app->basePath('stubs'));
        });
    }
}