<?php

namespace Audentio\LaravelBase\Illuminate\Database;

use Audentio\LaravelBase\Illuminate\Database\Schema\Blueprint;
use Audentio\LaravelBase\Illuminate\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use Carbon\Carbon;

class MySqlConnection extends \Illuminate\Database\MySqlConnection
{
    public function getSchemaBuilder()
    {
        $builder = parent::getSchemaBuilder();

        $builder->blueprintResolver(function($table, $callback) {
            return new Blueprint($table, $callback);
        });

        return $builder;
    }

    public function prepareBindings(array $bindings)
    {
        if (config('audentioBase.convertDateTimeToAppTimezoneBeforeSaving')) {
            foreach ($bindings as $key => $value) {
                if ($value instanceof Carbon
                    || $value instanceof \DateTime
                ) {
                    if ($value->getTimezone() !== config('app.timezone')) {
                        $bindings[$key] = $value->setTimezone(new \DateTimeZone(config('app.timezone')));
                    }
                }
            }
        }

        return parent::prepareBindings($bindings);
    }

    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }
}