<?php

namespace App\Repositories;

use App\Models\PhpcatruBlog;
use Illuminate\Database\Eloquent\Collection;

class BlogRepository
{
    public function getAllPublished(): Collection
    {
        return PhpcatruBlog::published()->latestNews()->get();
    }

    public function getBySlug(string $slug): ?PhpcatruBlog
    {
        return PhpcatruBlog::published()->where('slug', $slug)->first();
    }

    public function getLatest(int $limit = 2): Collection
    {
        return PhpcatruBlog::published()->latestNews()->take($limit)->get();
    }
}
