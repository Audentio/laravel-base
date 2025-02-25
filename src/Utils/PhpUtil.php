<?php

namespace Audentio\LaravelBase\Utils;

class PhpUtil
{
    public static function getClassNameForFilePath($filePath): string
    {
        $filePath = str_replace(app_path(), '', $filePath);
        $className = str_replace('/', '\\', str_replace('.php', '', $filePath));
        if (!str_starts_with($className, '\\')) {
            $className = '\\' . $className;
        }
        return 'App' . $className;
    }

    public static function varExport($var, $indent = ''): null|string
    {
        switch (gettype($var)) {
            case 'string':
                return '\'' . addcslashes($var, "\\\$'\r\n\t\v\f") . '\'';
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];

                foreach ($var as $key => $value) {
                    $r[] = $indent . '    '
                        . ($indexed ? '' : self::varExport($key) . ' => ')
                        . self::varExport($value, $indent . '    ');
                }
                if (empty($r)) {
                    return '[]';
                }
                return "[\n" . implode(",\n", $r) . "\n" . $indent . ']';
            default:
                return var_export($var, true);
        }
    }
}