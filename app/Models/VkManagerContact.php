<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VkManagerContact extends Model
{
    protected $fillable = ['user_id', 'vk_friend_id', 'is_favorite', 'comment'];

    protected $casts = ['is_favorite' => 'boolean'];
}
