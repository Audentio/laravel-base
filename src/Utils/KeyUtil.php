<?php

namespace Audentio\LaravelBoilerplate\Utils;

use Ramsey\Uuid\Uuid;

class KeyUtil
{
    public static function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    public static function guid($keySeedBytes): string
    {
        return self::base64ForUrl(openssl_random_pseudo_bytes($keySeedBytes));
    }

    public static function base64ForUrl($bytes): string
    {
        return str_replace([
            '+',
            '/',
            '=',
        ], [
            '_',
            '-',
            ''
        ], base64_encode($bytes));
    }
}