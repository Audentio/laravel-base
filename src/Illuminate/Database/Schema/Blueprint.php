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

    public function morphsNullable($name, $indexName = null)
    {
        $this->nullableMorphs($name, $indexName);
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
}
