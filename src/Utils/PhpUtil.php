<?php

namespace Audentio\LaravelBase\Utils;

class PhpUtil
{
    public static function varExport($var, $indent='')
    {
        switch(gettype($var)) {
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