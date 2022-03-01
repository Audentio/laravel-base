<?php

namespace Audentio\LaravelBase\Illuminate\Database\Schema;

use Illuminate\Database\Schema\ColumnDefinition;

class Blueprint extends \Illuminate\Database\Schema\Blueprint
{
    public function id($column = 'id', $primaryKey = true): ColumnDefinition
    {
        $columnBuilder = $this->uuid($column);
        if (\DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            $columnBuilder->collation('utf8mb4_bin');
        }

        if ($primaryKey) {
            $this->bigIncrements('incr_' . $column);
            $columnBuilder->unique();
        }

        return $columnBuilder;
    }

    public function remoteId($column): ColumnDefinition
    {
        return $this->id($column, false);
    }

    public function pivot($columnA, $columnB): void
    {
        $this->remoteId($columnA);
        $this->remoteId($columnB);

        $this->primary([$columnA, $columnB]);
    }

    public function morphsNullable($name, $indexName = null, ?string $after = null): void
    {
        $this->morphs($name, $indexName, true, $after);
    }

    public function blob($column): ColumnDefinition
    {
        return $this->addColumn('blob', $column);
    }

    public function mediumBlob($column): ColumnDefinition
    {
        return $this->addColumn('mediumBlob', $column);
    }

    public function longBlob($column): ColumnDefinition
    {
        return $this->addColumn('longBlob', $column);
    }

    public function morphs($name, $indexName = null, ?bool $nullable = false, ?string $after = null): void
    {
        $type = $this->string("{$name}_type");
        $id = $this->remoteId("{$name}_id");

        if ($nullable) {
            $type->nullable();
            $id->nullable();
        }

        if ($after) {
            $type->after($after);
            $id->after("{$name}_type");
        }

        $this->index(["{$name}_type", "{$name}_id"], $indexName);
    }
}
