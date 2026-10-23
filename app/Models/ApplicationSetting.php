<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    protected $primaryKey = 'scope';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['scope', 'values'];

    protected $hidden = ['values'];

    protected $casts = ['values' => 'encrypted:array'];
}
