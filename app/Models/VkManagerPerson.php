<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VkManagerPerson extends Model
{
    protected $fillable = [
        'vk_id', 'first_name', 'last_name', 'display_name', 'domain', 'photo_url', 'last_profile_sync_at',
    ];

    protected $casts = ['last_profile_sync_at' => 'datetime'];

    public function memberships(): HasMany
    {
        return $this->hasMany(VkManagerMembership::class, 'person_id');
    }
}
