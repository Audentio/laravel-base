<?php

namespace Audentio\LaravelBase\Utils;

class StrUtil
{
    public static function convertUnderscoresToCamelCase($string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    public static function convertUnderscoresToPascalCase($string): string
    {
        return ucfirst(self::convertUnderscoresToCamelCase($string));
    }
}