<?php

namespace Audentio\LaravelBase\Providers;

use Audentio\LaravelBase\Illuminate\Database\Migrations\MigrationCreator;
use Audentio\LaravelBase\Illuminate\Database\MySqlConnection;
use Audentio\LaravelBase\Illuminate\Foundation\Console\ModelMakeCommand;
use Audentio\LaravelBase\Illuminate\Routing\Console\ControllerMakeCommand;
use Audentio\LaravelBase\Traits\ExtendServiceProviderTrait;
use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;

class ExtendServiceProvider extends ServiceProvider
{
    use ExtendServiceProviderTrait;

    public function register()
    {
        $this->extendIlluminate();
        $this->extendDatabase();
    }

    protected function extendIlluminate()
    {
        $this->extendIlluminateCommands();
    }

    protected function extendIlluminateCommands()
    {
        $this->overrideIlluminateCommand('migration.creator', MigrationCreator::class);
        $this->overrideIlluminateCommand('command.model.make', ModelMakeCommand::class);
        $this->overrideIlluminateCommand('command.controller.make', ControllerMakeCommand::class);
    }

    protected function extendDatabase()
    {
        $this->extendDatabaseConnection('mysql', MySqlConnection::class);
    }

    protected function extendDatabaseConnection($connection, $className)
    {
        Connection::resolverFor($connection, function ($connection, $database, $prefix, $config) use ($className) {
            return new $className($connection, $database, $prefix, $config);
        });
    }
}