<?php

namespace App\Http\Controllers;

use App\Services\VkManagerPublicAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VkManagerPublicController extends Controller
{
    public function database(Request $request, string $token, VkManagerPublicAccessService $access): JsonResponse|Response
    {
        $headers = [
            'Cache-Control' => 'no-store, private',
            'X-Robots-Tag' => 'noindex, nofollow',
        ];

        $payload = $access->payload($token);
        if ($payload === null) {
            return response()->json(
                ['ok' => false, 'error' => 'Ссылка не найдена или уже перевыпущена.'],
                404,
                $headers,
                JSON_UNESCAPED_UNICODE,
            );
        }

        if ($request->query('format') === 'txt') {
            return response($access->toText($payload), 200, $headers + [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }

        return response()->json(
            $payload,
            200,
            $headers + ['Content-Type' => 'application/json; charset=UTF-8'],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        );
    }
}
