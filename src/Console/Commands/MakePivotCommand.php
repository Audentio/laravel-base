<?php

namespace Audentio\LaravelBase\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakePivotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pivot {tables*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new pivot migration';

    /**
     * The migration creator instance.
     *
     * @var \Illuminate\Database\Migrations\MigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    public function handle()
    {
        $tables = $this->argument('tables');
        sort($tables);

        foreach ($tables as &$tableName) {
            $tableName = Str::snake(Str::singular(class_basename($tableName)));
        }

        $table = implode('_', $tables);
        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }
}