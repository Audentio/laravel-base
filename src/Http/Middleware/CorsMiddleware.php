<?php

namespace Audentio\LaravelBase\Http\Middleware;

use Audentio\LaravelBase\LaravelBase;

class CorsMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        foreach (LaravelBase::getCorsHeaders() as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }
}