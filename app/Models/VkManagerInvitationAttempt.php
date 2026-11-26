<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VkManagerInvitationAttempt extends Model
{
    protected $fillable = [
        'user_id', 'vk_id', 'first_name', 'last_name', 'photo_url', 'started_at', 'resolved_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];
}
