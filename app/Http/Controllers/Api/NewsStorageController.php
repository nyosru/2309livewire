<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsStorageNews;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsStorageController extends Controller
{
    private function checkApiKey(Request $request): bool
    {
        $apiKey = $request->header('X-NewsStorage-Api-Key', $request->input('api_key'));
        return $apiKey === config('custom.NEWSSTORAGE_API_KEY');
    }

    public function store(Request $request): JsonResponse
    {
        if (!$this->checkApiKey($request)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $validated = $request->validate([
            'source_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $exists = \DB::connection('newsstorage')
                        ->table('newsstorage_sources')
                        ->where('id', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('The selected source_id is invalid.');
                    }
                },
            ],
            'url' => 'required|string|max:2048',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'media' => 'nullable|array',
            'media.*.url' => 'required_with:media|string|max:2048',
            'media.*.type' => 'required_with:media|string|max:50',
        ]);

        $news = NewsStorageNews::create([
            'source_id' => $validated['source_id'],
            'url' => $validated['url'],
            'title' => $validated['title'],
            'summary' => $validated['summary'] ?? null,
            'content' => $validated['content'] ?? null,
            'status' => 'new',
        ]);

        if (!empty($validated['media'])) {
            foreach ($validated['media'] as $mediaItem) {
                $news->media()->create([
                    'url' => $mediaItem['url'],
                    'type' => $mediaItem['type'],
                ]);
            }
        }

        $news->load('media');

        return response()->json([
            'message' => 'News record created successfully',
            'news' => $news,
        ], 201);
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        if (!$this->checkApiKey($request)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $news = NewsStorageNews::find($id);

        if (!$news) {
            return response()->json(['error' => 'News record not found'], 404);
        }

        $news->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Status updated successfully',
            'news' => $news,
        ]);
    }
}
