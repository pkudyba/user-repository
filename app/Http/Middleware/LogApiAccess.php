<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        Log::info("{$request->getMethod()}: {$request->getUri()}");

        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::info("{$request->getMethod()}: {$request->getUri()}");
        Log::info("Response: {$response->content()}");
    }
}
