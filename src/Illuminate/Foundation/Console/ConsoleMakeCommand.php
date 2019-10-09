<?php

namespace Audentio\LaravelBoilerplate\Illuminate\Foundation\Console;

use Audentio\LaravelBoilerplate\Traits\ExtendConsoleCommandTrait;
use Illuminate\Support\Str;

class ConsoleMakeCommand extends \Illuminate\Foundation\Console\ConsoleMakeCommand
{
    use ExtendConsoleCommandTrait;

    protected function qualifyClass($name)
    {
        $this->suffixCommandClass($name, 'Command');

        return parent::qualifyClass($name);
    }
}