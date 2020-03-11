<?php

namespace Audentio\LaravelBase\Illuminate\Foundation\Console;

use Audentio\LaravelBase\Traits\ExtendGeneratorCommandTrait;
use Illuminate\Database\Eloquent\Model;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    use ExtendGeneratorCommandTrait;

    protected function qualifyClass($name)
    {
        return $this->generateQualifyClass($name, [
            'namespaceTemplate' => config('audentioBase.modelGenerator.namespaceTemplate')
        ]);
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $baseClass = config('audentioBase.modelGenerator.base');

        $stub = $this->replaceBaseClassInStub(Model::class, $baseClass, $stub);

        return $stub;
    }
}