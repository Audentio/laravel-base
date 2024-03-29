<?php

namespace Audentio\LaravelBase\Traits;

use Illuminate\Support\Str;

trait ExtendConsoleCommandTrait
{
    protected function replaceClassReference($find, $replace, $stub): string
    {
        if (class_exists($replace)) {
            $stub = str_replace($find, $replace, $stub);
        }

        return $stub;
    }

    protected function replaceTraitReference($find, $replace, $stub): string
    {
        if (trait_exists($replace)) {
            $stub = str_replace($find, $replace, $stub);
        }

        return $stub;
    }

    protected function suffixCommandClass($name, $suffix): string
    {
        return $this->modifyCommandClass($name, $suffix, 'suffix');
    }

    protected function prefixCommandClass($name, $prefix): string
    {
        return $this->modifyCommandClass($name, $prefix, 'prefix');
    }

    protected function modifyCommandClass($className, $string, $modifyType): string
    {
        $classNameParts = explode('\\', $className);
        $name = array_pop($classNameParts);
        
        if (empty($string)) {
            return $name;
        }

        switch ($modifyType) {
            case 'prefix':
                if (!Str::startsWith($name, $string)) {
                    $name = $string . $name;
                }
                break;

            case 'suffix':
                if (!Str::endsWith($name, $string)) {
                    $name = $name . $string;
                }
                break;

            default:
                throw new \LogicException('Unknown $modifyType: ' . $modifyType);
        }

        $classNameParts[] = $name;

        return implode('\\', $classNameParts);
    }
}
