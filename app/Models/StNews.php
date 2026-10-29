<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'source',
        'published_at',
        'promo_code',
        'moderation_required',
        'told_at',
        'cat_id', // Добавляем это поле для заполнения
        'cover_photo_id', // Главное медиа (обложка) из st_news_media
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Связь с моделью StNewsParsingCategory
    public function category()
    {
        return $this->belongsTo(StNewsParsingCategory::class, 'cat_id');
    }

    // Связь с моделью StNewsParsingSite
    public function site()
    {
        return $this->belongsTo(StNewsParsingSite::class, 'site_id');
    }

    public function photos()
    {
        return $this->hasMany(StNewsPhoto::class);
    }

    public function firstPhoto()
    {
        return $this->photos()->first();
    }

    // Универсальные фото + видео (через API). Упорядочены по sort_order.
    public function media()
    {
        return $this->hasMany(StNewsMedia::class)->orderBy('sort_order')->orderBy('id');
    }

    // Главное фото/медиа «в самой новости» (обложка).
    public function coverPhoto()
    {
        return $this->belongsTo(StNewsMedia::class, 'cover_photo_id');
    }

    // Ключевые слова (существительные/глаголы): many-to-many, слова общие для новостей.
    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'st_news_keywords');
    }

    public function getIsPublishedAttribute(): bool
    {
        return ! empty($this->published_at);
    }

    /** Можно опубликовать: не опубликована, не удалена и прошло ≥ 2 суток с создания. */
    public function getCanPublishAttribute(): bool
    {
        if (! empty($this->published_at) || ! empty($this->deleted_at)) {
            return false;
        }

        return $this->created_at && $this->created_at->lte(now()->subDays(2));
    }

    /** Сколько суток осталось до возможности публикации (для подсказки в UI). */
    public function daysToPublish(): int
    {
        if (! empty($this->published_at) || ! empty($this->deleted_at) || ! $this->created_at) {
            return 0;
        }

        $hoursLeft = now()->diffInHours($this->created_at->copy()->addDays(2), false);

        return max(0, (int) ceil($hoursLeft / 24));
    }
}
