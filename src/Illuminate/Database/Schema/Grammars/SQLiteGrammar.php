<?php

namespace Audentio\LaravelBase\Illuminate\Database\Schema\Grammars;

use Illuminate\Support\Fluent;

class SQLiteGrammar extends \Illuminate\Database\Schema\Grammars\SQLiteGrammar
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