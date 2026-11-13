<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VkManagerAccount extends Model
{
    protected $fillable = ['user_id', 'vk_id', 'name', 'last_observed_at', 'last_full_sync_at'];

    protected $casts = ['last_observed_at' => 'datetime', 'last_full_sync_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(VkManagerMembership::class, 'account_id');
    }

    public function profileData(): HasMany
    {
        return $this->hasMany(VkManagerProfileData::class, 'account_id');
    }

    public function educationData(): HasMany
    {
        return $this->hasMany(VkManagerEducationData::class, 'account_id');
    }

    public function contactData(): HasMany
    {
        return $this->hasMany(VkManagerContactData::class, 'account_id');
    }
}
