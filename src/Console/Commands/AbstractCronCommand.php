<?php

namespace Audentio\LaravelBase\Console\Commands;

use Illuminate\Console\Command;

abstract class AbstractCronCommand extends Command
{
    public function handle()
    {
        $this->runCron();
        return 0;
    }

    protected function buildDefaultSignature()
    {
        if (empty($this->signature)) {
            $classParts = explode('\\', get_class($this));
            $className = array_pop($classParts);
            if (str_ends_with($className, 'Command')) {
                $className = substr($className, 0, -7);
            }
            if (str_starts_with($className, 'Cron')) {
                $className = substr($className, 4);
            }

            $signature = strtolower(preg_replace('/(?<!^)[A-Z]+|(?<!^|\d)[\d]+/', '-'.'$0', lcfirst($className)));

            $this->signature = 'cron:' . $signature;
        }
    }

    abstract protected function runCron();

    public function __construct()
    {
        $this->buildDefaultSignature();

        parent::__construct();
    }
}