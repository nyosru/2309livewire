<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'calls_branches';

    protected $fillable = ['parent_id', 'name', 'type', 'project'];
}
