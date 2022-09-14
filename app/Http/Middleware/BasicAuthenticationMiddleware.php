<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Текст, отправляемый в том случае,
    если пользователь нажал кнопку Cancel';
            exit;
        }

        if ($_SERVER['PHP_AUTH_USER'] == config('auth.basic_user') &&
            $_SERVER['PHP_AUTH_PW'] == config('auth.basic_pwd'))
            return $next($request);

        abort(401);
    }
}
