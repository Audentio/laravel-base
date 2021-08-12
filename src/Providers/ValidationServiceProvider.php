<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Validation\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationServiceProvider as BaseValidationServiceProvider;

class ValidationServiceProvider extends BaseValidationServiceProvider
{
    public function register()
    {
        $providers = config('app.providers');
        $validationProviderKey = array_search('Illuminate\Validation\ValidationServiceProvider', $providers);
        if ($validationProviderKey !== false) {
            unset($providers[$validationProviderKey]);
        }

        $providers = array_values($providers);
        config([
            'app.providers' => $providers,
        ]);

        parent::register();
    }

    protected function registerValidationFactory()
    {
        $this->app->singleton('validator', function ($app) {
            $validator = new Factory($app['translator'], $app);

            // The validation presence verifier is responsible for determining the existence
            // of values in a given data collection, typically a relational database or
            // other persistent data stores. And it is used to check for uniqueness.
            if (isset($app['db']) && isset($app['validation.presence'])) {
                $validator->setPresenceVerifier($app['validation.presence']);
            }

            return $validator;
        });
    }
}