<?php

namespace Audentio\LaravelBase\Illuminate\Database\Migrations;

use Audentio\LaravelBase\Illuminate\Database\Schema\Blueprint;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    protected function getStub($table, $create)
    {
        $stub = parent::getStub($table, $create);

        $additionalClasses = [
            Blueprint::class
        ];
        foreach ($additionalClasses as &$className) {
            $className = 'use ' . $className . ';';
        }

        return str_replace([
            "<?php\n\n",
            'use Illuminate\Database\Schema\Blueprint;' . "\n",
            '$table->bigIncrements(\'id\');',
        ], [
            "<?php\n\n" . implode("\n", $additionalClasses) . "\n",
            '',
            '$table->id();',
        ], $stub);
    }
}