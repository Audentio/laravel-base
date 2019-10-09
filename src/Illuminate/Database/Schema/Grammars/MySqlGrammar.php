<?php

namespace Audentio\LaravelBoilerplate\Illuminate\Database\Schema\Grammars;

class MySqlGrammar extends \Illuminate\Database\Schema\Grammars\MySqlGrammar
{
    protected function typeBlob(Fluent $column): string
    {
        return 'blob';
    }

    protected function typeMediumBlob(Fluent $column): string
    {
        return 'mediumblob';
    }

    protected function typeLongBlob(Fluent $column): string
    {
        return 'longblob';
    }
}