<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsStorageNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsstorage_news';

    protected $fillable = [
        'source_id',
        'url',
        'source',
        'source_domain',
        'site_id',
        'cat_id',
        'title',
        'summary',
        'content',
        'status',
        'status_show',
        'published_at',
        'news_date',
        'promo_code',
        'moderation',
        'moderation_required',
        'moderation_date',
        'moderation_who',
        'told_at',
        'cover_photo_id',
        'legacy_st_news_id',
        'is_stn',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'news_date' => 'date',
        'moderation_date' => 'datetime',
        'told_at' => 'datetime',
        'moderation' => 'boolean',
        'moderation_required' => 'boolean',
        'is_stn' => 'boolean',
    ];

    protected $hidden = ['legacy_st_news_id'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->where('status', 'published')->orWhereNotNull('published_at');
        });
    }

    public function scopeInPublicFeed(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->where('status', 'published')->orWhereNotNull('published_at');
        })->where('content', '!=', '');
    }

    public function scopeStn(Builder $query): Builder
    {
        return $query->where('is_stn', true);
    }

    public function setSourceAttribute($value): void
    {
        $this->attributes['source'] = $value;
        if (empty($this->attributes['url'])) {
            $this->attributes['url'] = $value;
        }
    }

    protected static function booted(): void
    {
        static::saving(function (self $news): void {
            if ($news->source || $news->site_id || $news->cat_id) {
                $news->is_stn = true;
            }
            if (! $news->isDirty('published_at')) {
                return;
            }

            if ($news->published_at) {
                $news->status = 'published';
            } elseif ($news->status === 'published') {
                $news->status = 'new';
            }
        });
    }

    public function changeStatus(string $status): void
    {
        if ($status === $this->status) {
            return;
        }

        $this->status = $status;
        $this->published_at = $status === 'published' ? now() : null;
        $this->save();
    }

    public static function resolveLegacyOrCurrent($id): self
    {
        return static::stn()->where('legacy_st_news_id', $id)->first()
            ?? static::stn()->findOrFail($id);
    }

    public function storageSource()
    {
        return $this->belongsTo(NewsStorageSource::class, 'source_id');
    }

    public function media()
    {
        return $this->hasMany(StNewsMedia::class, 'newsstorage_news_id')->orderBy('sort_order')->orderBy('id');
    }

    public function storageMedia()
    {
        return $this->hasMany(NewsStorageMedia::class, 'news_id');
    }

    public function videoBlogRead()
    {
        return $this->hasOne(NewsStorageVideoBlogRead::class, 'newsstorage_news_id');
    }

    public function topics()
    {
        return $this->belongsToMany(NewsTopic::class, 'news_topic_news', 'news_id', 'topic_id')
            ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(StNewsPhoto::class, 'newsstorage_news_id');
    }

    public function firstPhoto()
    {
        return $this->photos()->first();
    }

    public function coverPhoto()
    {
        return $this->belongsTo(StNewsMedia::class, 'cover_photo_id');
    }

    public function site()
    {
        return $this->belongsTo(StNewsParsingSite::class, 'site_id');
    }

    public function category()
    {
        return $this->belongsTo(StNewsParsingCategory::class, 'cat_id');
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'st_news_keywords', 'newsstorage_news_id', 'keyword_id');
    }

    public function getIsPublishedAttribute(): bool
    {
        return ! empty($this->published_at);
    }

    public function getCanPublishAttribute(): bool
    {
        return empty($this->published_at) && empty($this->deleted_at)
            && $this->created_at && $this->created_at->lte(now()->subDays(2));
    }

    public function daysToPublish(): int
    {
        if (! empty($this->published_at) || ! empty($this->deleted_at) || ! $this->created_at) {
            return 0;
        }
        $hoursLeft = now()->diffInHours($this->created_at->copy()->addDays(2), false);
        return max(0, (int) ceil($hoursLeft / 24));
    }
}
