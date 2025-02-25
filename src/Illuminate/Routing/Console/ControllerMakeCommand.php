<?php

namespace Audentio\LaravelBase\Illuminate\Routing\Console;

use Audentio\LaravelBase\Traits\ExtendGeneratorCommandTrait;
use Illuminate\Console\GeneratorCommand;

class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    use ExtendGeneratorCommandTrait;

    protected function qualifyClass($name)
    {
        return $this->generateQualifyClass($name, [
            'suffix' => 'Controller',
        ]);
    }

    protected function buildClass($name)
    {
        $stub = GeneratorCommand::buildClass($name);
        $stub = $this->replaceBaseClassInStub('App\Http\Controllers\Controller', config('audentioBase.controllerGenerator.base'), $stub);

        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        $replace["use {$controllerNamespace}\AbstractController;\n"] = '';

        if (class_exists($controllerNamespace) . '\\AbstractController') {
            $replace["use " . config('audentioBase.controllerGenerator.base') . ";\n"] = '';
        }

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }
}
