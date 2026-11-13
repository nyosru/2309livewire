<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VkManagerContactData extends Model
{
    protected $fillable = ['account_id', 'person_id', 'data', 'source', 'obsolete_at'];

    protected $casts = ['data' => 'array', 'obsolete_at' => 'datetime'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(VkManagerAccount::class, 'account_id');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(VkManagerPerson::class, 'person_id');
    }
}
