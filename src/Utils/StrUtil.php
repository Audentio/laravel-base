<?php

namespace Audentio\LaravelBase\Utils;

class StrUtil
{
    public static function convertUnderscoresToCamelCase($string)
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    public static function convertUnderscoresToPascalCase($string)
    {
        return ucfirst(self::convertUnderscoresToCamelCase($string));
    }
}