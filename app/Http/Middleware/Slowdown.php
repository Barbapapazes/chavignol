<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Sleep;
use Symfony\Component\HttpFoundation\Response;

class Slowdown
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() !== 'GET'
        && $request->method() !== 'HEAD'
        && $request->method() !== 'OPTIONS'
        && mb_strpos($request->path(), 'api') === 0) {
            Sleep::for(config('app.sleep_time'))->seconds();
        }

        return $next($request);
    }
}
