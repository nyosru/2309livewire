<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhpcatruBlog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $apiKey = $request->header('X-Blog-Api-Key', $request->input('api_key'));

        if ($apiKey !== config('custom.BLOG_API_KEY')) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']);

        $post = PhpcatruBlog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'tag' => $validated['tag'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'is_published' => $validated['is_published'] ?? true,
            'published_at' => ($validated['is_published'] ?? true) ? now() : null,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'url' => url('/blog/' . $post->slug),
            ],
        ], 201);
    }
}
