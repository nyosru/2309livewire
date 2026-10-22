<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMaxServiceClient
{
    public function handle(Request $request, Closure $next)
    {
        $client = (string) $request->header('X-Max-Service-Client');
        $clients = config('max.service_clients');
        $expected = is_array($clients) ? ($clients[$client] ?? null) : null;
        abort_unless(preg_match('/^[a-z0-9_-]{1,40}$/D', $client)
            && is_string($expected) && strlen($expected) >= 32
            && hash_equals($expected, (string) $request->header('X-Max-Service-Key')), 403);
        $request->attributes->set('max_service_client', $client);

        return $next($request);
    }
}
