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
        'title',
        'summary',
        'content',
        'status',
        'status_show',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
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

    public function source()
    {
        return $this->belongsTo(NewsStorageSource::class, 'source_id');
    }

    public function media()
    {
        return $this->hasMany(NewsStorageMedia::class, 'news_id');
    }
}
