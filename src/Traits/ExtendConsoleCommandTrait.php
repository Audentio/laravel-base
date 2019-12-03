<?php

namespace Audentio\LaravelBase\Traits;

use Illuminate\Support\Str;

trait ExtendConsoleCommandTrait
{
    protected function suffixCommandClass($name, $suffix): string
    {
        return $this->modifyCommandClass($name, $suffix, 'suffix');
    }

    protected function prefixCommandClass($name, $prefix): string
    {
        return $this->modifyCommandClass($name, $prefix, 'prefix');
    }

    protected function modifyCommandClass($name, $string, $modifyType): string
    {
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

        return $name;
    }
}