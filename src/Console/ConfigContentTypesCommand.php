<?php

namespace Audentio\LaravelBase\Console\Commands;

use Audentio\LaravelBase\Utils\PhpUtil;

class ConfigContentTypesCommand extends AbstractConfigCommand
{
    protected function getConfig(): array
    {
        $data = [];

        foreach (glob(app_path('Models/*.php')) as $filePath) {
            $fileParts = explode('/', $filePath);
            $fileName = array_pop($fileParts);
            if (strpos($fileName, 'Abstract') === 0) continue;

            $className = PhpUtil::getClassNameForFilePath($filePath);

            $contentTypeFields = call_user_func([$className, 'getContentTypeFields']);

            $data[$className] = $contentTypeFields;
        }

        return $data;
    }

    protected function getConfigFileName(): string
    {
        return 'contentTypes.php';
    }
}