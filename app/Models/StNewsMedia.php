<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StNewsMedia extends Model
{
    use HasFactory;

    const TYPE_PHOTO = 'photo';
    const TYPE_VIDEO = 'video';

    protected $table = 'st_news_media';

    protected $fillable = [
        'st_news_id',
        'media_type',
        'photo_path',
        'local_photo',
        'video_url',
        'provider',
        'video_title',
        'thumbnail_path',
        'duration',
        'title',
        'alt',
        'sort_order',
    ];

    protected $casts = [
        'duration' => 'integer',
        'sort_order' => 'integer',
    ];

    // Accessor'ы не сериализуются в toArray/json автоматически — явно добавляем.
    protected $appends = ['url', 'is_photo', 'is_video'];

    public function news()
    {
        return $this->belongsTo(StNews::class, 'st_news_id');
    }

    public function scopePhotos($query)
    {
        return $query->where('media_type', self::TYPE_PHOTO);
    }

    public function scopeVideos($query)
    {
        return $query->where('media_type', self::TYPE_VIDEO);
    }

    public function getIsPhotoAttribute(): bool
    {
        return $this->media_type === self::TYPE_PHOTO;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->media_type === self::TYPE_VIDEO;
    }

    /**
     * Удобный URL для шаблона/API: для фото — локальная копия или исходник,
     * для видео — ссылка на видео.
     */
    public function getUrlAttribute(): ?string
    {
        if ($this->media_type === self::TYPE_VIDEO) {
            return $this->video_url;
        }

        return $this->local_photo ?: $this->photo_path;
    }
}
