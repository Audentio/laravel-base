<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Foundation\Console\ConsoleMakeCommand;
use Audentio\LaravelBase\Illuminate\Foundation\Console\ModelMakeCommand;
use Audentio\LaravelBase\Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Console\ConsoleMakeCommand as BaseConsoleMakeCommand;
use Illuminate\Routing\Console\ControllerMakeCommand as BaseControllerMakeCommand;
use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as BaseArtisanServiceProvider;

class ArtisanServiceProvider extends BaseArtisanServiceProvider implements DeferrableProvider
{

    protected function registerConsoleMakeCommand()
    {
        $this->app->singleton(BaseConsoleMakeCommand::class, function ($app) {
            return new ConsoleMakeCommand($app['files']);
        });
    }

    protected function registerControllerMakeCommand()
    {
        $this->app->singleton(BaseControllerMakeCommand::class, function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }

    protected function registerModelMakeCommand()
    {
        $this->app->singleton(BaseModelMakeCommand::class, function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }
}