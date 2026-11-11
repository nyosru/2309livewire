<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NewsTopic extends Model
{
    protected $fillable = [
        'name_ru',
        'name_en',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function news()
    {
        return $this->belongsToMany(NewsStorageNews::class, 'news_topic_news', 'topic_id', 'news_id')
            ->withTimestamps();
    }
}
