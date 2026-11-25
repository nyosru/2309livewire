<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VkAuthorVideoDailySnapshot extends Model
{
    protected $fillable = [
        'snapshot_date', 'media_type', 'owner_id', 'video_id', 'title', 'views',
        'duration', 'published_at', 'thumbnail_url', 'video_url', 'captured_at',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
        'published_at' => 'datetime',
        'captured_at' => 'datetime',
    ];
}
