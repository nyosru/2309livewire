<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStnApiKey
{
    /**
     * Проверяет заголовок X-STN-Api-Key (или Authorization: Bearer <key>).
     | Ключ берётся из config('stn.api_key') (env STN_API_KEY).
     * Если ключ не настроен — пропускаем (локальная разработка).
     */
    public function handle(Request $request, Closure $next)
    {
        $key = config('stn.api_key');

        if (empty($key)) {
            return $next($request);
        }

        $provided = $request->header('X-STN-Api-Key');

        if (!$provided) {
            $auth = $request->header('Authorization', '');
            if (str_starts_with($auth, 'Bearer ')) {
                $provided = substr($auth, 7);
            }
        }

        if (! is_string($provided) || ! hash_equals($key, $provided)) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Неверный или отсутствующий STN API ключ.',
            ], 401);
        }

        return $next($request);
    }
}
