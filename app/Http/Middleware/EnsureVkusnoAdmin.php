<?php

namespace App\Http\Middleware;

use App\Models\Vkusno\Administrator;
use Closure;
use Illuminate\Http\Request;

class EnsureVkusnoAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                abort(401);
            }

            return redirect()->guest('/admin/login');
        }

        abort_unless(Administrator::canManage($request->user()), 403);

        return $next($request);
    }
}
