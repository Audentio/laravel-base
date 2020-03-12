<?php

namespace Audentio\LaravelBase\Traits;

use Illuminate\Support\Str;

trait ExtendGeneratorCommandTrait
{
    use ExtendConsoleCommandTrait;

    public function generateQualifyClass($name, array $options = []): string
    {
        $options = array_merge([
            'suffix' => '',
            'prefix' => '',
            'namespaceTemplate' => '',
        ], $options);
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);
        $rawClassName = $name;

        $name = $this->prefixCommandClass($name, $options['prefix']);
        $name = $this->suffixCommandClass($name, $options['suffix']);

        return $this->generateQualifyClass(
            $this->generateNamespace(trim($rootNamespace, '\\'), $options['namespaceTemplate'], [
                'ClassName' => $name,
                'RawClassName' => $rawClassName,
            ]).'\\'.$name
        );
    }

    public function generateNamespace($rootNamespace, $template = '', array $vars = []): string
    {
        if (empty($template)) {
            return $this->getDefaultNamespace($rootNamespace);
        }
        $namespace = $template;

        $vars['RootNamespace'] = $rootNamespace;
        foreach ($vars as $name => $value) {
            $namespace = str_ireplace('{{' . $name . '}}', $value, $namespace);
        }

        return $namespace;
    }

    public function replaceBaseClassInStub($oldBaseClass, $newBaseClass, $stub): string
    {
        if ($newBaseClass) {
            $newBaseClassParts = explode('\\', $newBaseClass);
            $newBaseClassName = end($newBaseClassParts);

            $oldBaseClassParts = explode('\\', $oldBaseClass);
            $oldBaseClassName = end($oldBaseClassParts);

            $stub = str_replace('use ' . $oldBaseClass . ';', 'use ' . $newBaseClass . ';', $stub);
            $stub = str_replace('extends ' . $oldBaseClassName, 'extends ' . $newBaseClassName . '', $stub);
        }

        return $stub;
    }
}