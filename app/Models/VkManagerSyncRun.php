<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VkManagerSyncRun extends Model
{
    public const STATUS_COUNTING = 'counting';

    public const STATUS_RUNNING = 'running';

    public const STATUS_FAILED = 'failed';

    public const STATUS_FINALIZING = 'finalizing';

    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'account_id', 'status', 'current_list', 'current_page', 'error_page', 'error_list',
        'error_message', 'progress', 'started_at', 'completed_at',
    ];

    protected $casts = [
        'progress' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'next_request_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(VkManagerAccount::class, 'account_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(VkManagerSyncItem::class, 'run_id');
    }
}
