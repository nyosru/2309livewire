<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNewsStorageApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $expectedKey = config('custom.NEWSSTORAGE_API_KEY');
        $providedKey = $request->header('X-NewsStorage-Api-Key', $request->input('api_key'));

        if (! is_string($expectedKey) || $expectedKey === '' || ! is_string($providedKey)
            || ! hash_equals($expectedKey, $providedKey)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
