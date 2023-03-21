<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
{
    public function handle($request, Closure $next)
    {
        if ($_SERVER["HTTP_X_FORWARDED_PROTO"] === "https") {
            \URL::forceScheme('https');
        }
        return $next($request);
    }
}
