<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', env('APP_SWAGGER'))
            ->header('Access-Control-Allow-Headers', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Request-Origin', env('APP_SWAGGER'))
            ->header('Access-Control-Request-Headers', '*')
            ->header('Access-Control-Request-Methods', '*');
    }
}