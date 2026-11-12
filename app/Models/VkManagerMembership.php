<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VkManagerMembership extends Model
{
    public const STATUS_FRIEND = 'friend';

    public const STATUS_FOLLOWER = 'follower';

    protected $fillable = [
        'account_id', 'person_id', 'status', 'is_current', 'started_at', 'ended_at', 'source',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(VkManagerAccount::class, 'account_id');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(VkManagerPerson::class, 'person_id');
    }
}
