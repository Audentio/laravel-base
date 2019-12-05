<?php

namespace Audentio\LaravelBase;

class LaravelBase
{
    public static function getCorsHeaders()
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => 3600,
            'Access-Control-Allow-Headers' => 'Authorization, Content-type, Accept, X-Api-Version, X-Frontend-Uri, Locale',
            'Access-Control-Allow-Methods' => 'POST, GET, PUT, DELETE, OPTIONS',
        ];
    }
}