<?php

namespace App\Http\Middleware;

use App\Models\NewsStorageAdministrator;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNewsStorageModerator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect('/admin/login');
        }

        $access = NewsStorageAdministrator::query()->where('user_id', $request->user()->id)->first();
        if (! $access?->canModerate()) {
            return redirect('/admin/login')->with('access-denied', true);
        }

        return $next($request);
    }
}
