<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRaalAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('raal_admin_authenticated') !== true) {
            $request->session()->put('url.intended', $request->fullUrl());

            return redirect()->route('raal.admin.login');
        }

        return $next($request);
    }
}
