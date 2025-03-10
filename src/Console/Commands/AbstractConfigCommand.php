<?php

namespace Audentio\LaravelBase\Console\Commands;

use Audentio\LaravelBase\Utils\PhpUtil;
use Illuminate\Console\Command;

abstract class AbstractConfigCommand extends Command
{
    public function handle()
    {
        $configFile = config_path($this->getConfigFileName());

        $config = <<<EOF
<?php

/*
 * Do not directly edit this file as it is automatically generated using
 * the command line.
 * 
 * To regenerate this config file please run:
 * php artisan {$this->name}
 */
EOF;

        $config .= "\n\nreturn " . PhpUtil::varExport($this->getConfig()) . ';';

        $fh = fopen($configFile, 'w+');
        fwrite($fh, $config);
        fclose($fh);

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
            if (str_starts_with($className, 'Config')) {
                $className = substr($className, 6);
            }

            $signature = strtolower(preg_replace('/(?<!^)[A-Z]+|(?<!^|\d)[\d]+/', '-'.'$0', lcfirst($className)));

            $this->signature = 'config:' . $signature;
        }
    }

    public function __construct()
    {
        $this->buildDefaultSignature();

        parent::__construct();
    }

    abstract protected function getConfig(): array;
    abstract protected function getConfigFileName(): string;
}