<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsStorageSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewsStorageSourceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $limit = min(max((int) $request->query('limit', 50), 1), 100);

        return response()->json(
            NewsStorageSource::query()
                ->withCount('news')
                ->orderBy('id')
                ->paginate($limit)
        );
    }

    public function show(int $id): JsonResponse
    {
        $source = NewsStorageSource::query()->withCount('news')->find($id);

        if (! $source) {
            return response()->json(['error' => 'Source not found'], 404);
        }

        return response()->json(['source' => $source]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:2048', Rule::unique('newsstorage_sources', 'url')],
            'parsing_instructions' => ['nullable', 'string', 'max:10000'],
        ]);

        $source = NewsStorageSource::create($data);

        return response()->json([
            'message' => 'Source created successfully',
            'source' => $source->loadCount('news'),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $source = NewsStorageSource::find($id);

        if (! $source) {
            return response()->json(['error' => 'Source not found'], 404);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'url' => [
                'sometimes', 'required', 'url', 'max:2048',
                Rule::unique('newsstorage_sources', 'url')->ignore($source->id),
            ],
            'parsing_instructions' => ['sometimes', 'nullable', 'string', 'max:10000'],
        ]);

        $source->update($data);

        return response()->json([
            'message' => 'Source updated successfully',
            'source' => $source->fresh()->loadCount('news'),
        ]);
    }
}
