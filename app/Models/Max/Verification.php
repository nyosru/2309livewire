<?php

namespace App\Models\Max;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $table = 'max_verifications';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $hidden = ['phone', 'browser_hash', 'code_hash'];

    protected $casts = [
        'code_length' => 'integer', 'attempts' => 'integer',
        'expires_at' => 'datetime', 'consumed_at' => 'datetime',
    ];
}
