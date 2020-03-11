<?php

namespace Audentio\LaravelBase\Traits;

trait ExtendServiceProviderTrait
{
    protected function overrideIlluminateCommand($abstract, $newClass, ...$args)
    {
        $this->app->extend($abstract, function($class, $app) use ($newClass, $args) {
            array_unshift($args, $app['files']);

            return new $newClass(...$args);
        });
    }

    protected function overrideIlluminateSingleton($abstract, $newClass) {
        $this->app->singleton($abstract, function($app) use ($newClass) {
            return new $newClass($app);
        });
    }
}