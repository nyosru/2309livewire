<?php

namespace App\Models\Cals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    protected $table = 'cals_calls';

    protected $fillable = [
        'contact_id', 'phone', 'call_at', 'duration_seconds', 'transcript', 'summary', 'metadata', 'source_path',
    ];

    protected $casts = [
        'call_at' => 'datetime',
        'metadata' => 'array',
        'is_deleted' => 'boolean',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
