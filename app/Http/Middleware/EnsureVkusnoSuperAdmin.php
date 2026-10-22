<?php

namespace App\Http\Middleware;

use App\Models\Vkusno\Administrator;
use Closure;
use Illuminate\Http\Request;

class EnsureVkusnoSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user() && Administrator::isSuperAdmin($request->user()), 403);

        return $next($request);
    }
}
