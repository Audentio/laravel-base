<?php

namespace Audentio\LaravelBase\Illuminate\Database\Schema\Grammars;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Fluent;

class SQLiteGrammar extends \Illuminate\Database\Schema\Grammars\SQLiteGrammar
{
    protected function modifyDefault(Blueprint $blueprint, Fluent $column)
    {
        if (!$column->nullable && $column->default === null && $column->type === 'string') {
            $column->default = '';
        }

        if (! is_null($column->default) && is_null($column->virtualAs) && is_null($column->storedAs)) {
            return ' default '.$this->getDefaultValue($column->default);
        }
    }

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
