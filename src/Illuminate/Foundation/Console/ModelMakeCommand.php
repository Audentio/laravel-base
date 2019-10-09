<?php

namespace Audentio\LaravelBoilerplate\Illuminate\Foundation\Console;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $classExists = false;
        try {
            if (class_exists('App\Models\AbstractModel')) {
                $classExists = true;
            }
        } catch (\ErrorException $e) {}

        if ($classExists) {
            $extend = '';
        } else {
            $extend = 'use Audentio\LaravelBoilerplate\AbstractModel;' . "\n\n";
        }

        $stub = str_replace([
            'use Illuminate\Database\Eloquent\Model;' . "\n\n",
            'extends Model',
        ], [
            $extend,
            'extends AbstractModel'
        ], $stub);

        return $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }
}