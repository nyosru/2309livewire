<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsStorageVideoBlogRead extends Model
{
    protected $table = 'newsstorage_video_blog_reads';

    protected $fillable = [
        'news_id',
        'newsstorage_news_id',
        'read_at',
        'number',
    ];

    protected $casts = [
        'read_at' => 'date',
        'number' => 'integer',
    ];

    public function news()
    {
        return $this->belongsTo(NewsStorageNews::class, 'newsstorage_news_id');
    }
}
