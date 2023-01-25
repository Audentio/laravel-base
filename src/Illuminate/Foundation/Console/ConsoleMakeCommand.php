<?php

namespace Audentio\LaravelBase\Illuminate\Foundation\Console;

use Audentio\LaravelBase\Traits\ExtendConsoleCommandTrait;
use Illuminate\Support\Str;

class ConsoleMakeCommand extends \Illuminate\Foundation\Console\ConsoleMakeCommand
{
    use ExtendConsoleCommandTrait;

    protected function qualifyClass($name)
    {
        $name = $this->suffixCommandClass($name, 'Command');

        return parent::qualifyClass($name);
    }
}