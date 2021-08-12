<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Database\Migrations\MigrationCreator;
use Audentio\LaravelBase\Illuminate\Database\MySqlConnection;
use Audentio\LaravelBase\Illuminate\Database\SQLiteConnection;
use Audentio\LaravelBase\Illuminate\Foundation\Console\ModelMakeCommand;
use Audentio\LaravelBase\Illuminate\Routing\Console\ControllerMakeCommand;
use Audentio\LaravelBase\Illuminate\Validation\Validator;
use Audentio\LaravelBase\Traits\ExtendServiceProviderTrait;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class ExtendServiceProvider extends ServiceProvider
{
    use ExtendServiceProviderTrait;

    public function register(): void
    {
        $this->extendIlluminate();
        $this->extendDatabase();
    }

    protected function extendIlluminate(): void
    {
        $this->extendIlluminateCommands();
    }

    protected function extendIlluminateCommands(): void
    {
        $this->overrideIlluminateCommand('migration.creator', MigrationCreator::class, $this->app->basePath('stubs'));
        $this->overrideIlluminateCommand('command.model.make', ModelMakeCommand::class);
        $this->overrideIlluminateCommand('command.controller.make', ControllerMakeCommand::class);
    }

    protected function extendDatabase(): void
    {
        $this->extendDatabaseConnection('mysql', MySqlConnection::class);
        $this->extendDatabaseConnection('sqlite', SQLiteConnection::class);
    }

    protected function extendDatabaseConnection($connection, $className): void
    {
        Connection::resolverFor($connection, function ($connection, $database, $prefix, $config) use ($className) {
            return new $className($connection, $database, $prefix, $config);
        });
    }
}