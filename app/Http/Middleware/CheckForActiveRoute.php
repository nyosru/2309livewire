<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckForActiveRoute
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
        if (!Route::has($request->route()->getName())) {
            return response()->json(['message' => 'Привет пух пух'], 404);
        }

        return $next($request);
    }
}
