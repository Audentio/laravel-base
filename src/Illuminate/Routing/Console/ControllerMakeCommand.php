<?php

namespace Audentio\LaravelBase\Illuminate\Routing\Console;

class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    protected function getStub()
    {
        $stub = null;

        if ($this->option('api')) {
            $stub = '/stubs/controller.api.stub';
        }

        $stub = $stub ?? '/stubs/controller.plain.stub';

        return __DIR__ . $stub;
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $api = $this->option('api');
        $classExists = false;
        try {
            if ($api) {
                if (class_exists('App\Http\Controllers\Api\AbstractApiController')) {
                    $classExists = true;
                }
            } else {
                if (class_exists('App\Http\Controllers\AbstractController')) {
                    $classExists = true;
                }
            }
        } catch (\ErrorException $e) {}

        if ($classExists) {
            $defaultNamespace = str_replace('\\\\', '\\', $this->getDefaultNamespace($this->rootNamespace()));
            $controllerNamespace = $this->getNamespace($name);
            $extend = '';

            if ($defaultNamespace !== $controllerNamespace) {
                if ($api) {
                    $extend = 'use App\Http\Controllers\Api\AbstractApiController;' . "\n";
                } else {
                    $extend = 'use App\Http\Controllers\AbstractController;' . "\n";
                }
            }
        } else {
            if ($api) {
                $extend = 'use Audentio\LaravelBase\Http\Controllers\Api\AbstractApiController;' . "\n";
            } else {
                $extend = 'use Audentio\LaravelBase\Http\Controllers\AbstractController;' . "\n";
            }
        }
        $extend .= 'use Illuminate\Http\Request;' . "\n\n";

        $controllerClass = 'AbstractController';
        if ($api) {
            $controllerClass = 'AbstractApiController';
        }

        $stub = str_replace([
            'use Illuminate\Http\Request;' . "\n\n",
            'extends Controller',
        ], [
            $extend,
            'extends ' . $controllerClass,
        ], $stub);

//        dump($stub);die;

        return $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = parent::getDefaultNamespace($rootNamespace);

        if ($this->option('api')) {
            $namespace = $namespace . '\Api';
        }

        return $namespace;
    }
}