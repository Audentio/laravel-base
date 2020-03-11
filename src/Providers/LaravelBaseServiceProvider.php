<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Database\Migrations\MigrationCreator;
use Audentio\LaravelBase\Illuminate\Database\MySqlConnection;
use Audentio\LaravelBase\Illuminate\Foundation\Console\ModelMakeCommand;
use Audentio\LaravelBase\Illuminate\Routing\Console\ControllerMakeCommand;
use Audentio\LaravelBase\Traits\ExtendServiceProviderTrait;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class LaravelBaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/audentioBase.php', 'audentioBase'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/audentioBase.php' => config_path('audentioBase.php'),
        ]);
    }
}