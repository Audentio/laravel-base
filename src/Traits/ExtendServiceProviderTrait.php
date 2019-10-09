<?php

namespace Audentio\LaravelBoilerplate\Traits;

trait ExtendServiceProviderTrait
{
    protected function overrideIlluminateCommand($abstract, $newClass)
    {
        $this->app->extend($abstract, function($class, $app) use ($newClass) {
            return new $newClass($app['files']);
        });
    }

    protected function overrideIlluminateSingleton($abstract, $newClass) {
        $this->app->singleton($abstract, function($app) use ($newClass) {
            return new $newClass($app);
        });
    }
}