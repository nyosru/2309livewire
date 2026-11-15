<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VkManagerSyncItem extends Model
{
    protected $fillable = ['run_id', 'list_name', 'vk_id', 'payload'];

    protected $casts = ['payload' => 'array'];

    public function run(): BelongsTo
    {
        return $this->belongsTo(VkManagerSyncRun::class, 'run_id');
    }
}
