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
            if (substr($className, -7) === 'Command') {
                $className = substr($className, 0, -7);
            }
            if (substr($className, 0, 4) === 'Cron') {
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