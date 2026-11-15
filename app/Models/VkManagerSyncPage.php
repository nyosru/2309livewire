<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VkManagerSyncPage extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_LOADING = 'loading';

    public const STATUS_LOADED = 'loaded';

    public const STATUS_ERROR = 'error';

    protected $fillable = [
        'run_id', 'list_name', 'page_number', 'status', 'error_message', 'started_at', 'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(VkManagerSyncRun::class, 'run_id');
    }
}
