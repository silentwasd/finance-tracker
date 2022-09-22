<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('auth.basic_active'))
            return $next($request);

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            abort(401);
        }

        if ($_SERVER['PHP_AUTH_USER'] == config('auth.basic_user') &&
            $_SERVER['PHP_AUTH_PW'] == config('auth.basic_pwd'))
            return $next($request);

        abort(401);
    }
}
