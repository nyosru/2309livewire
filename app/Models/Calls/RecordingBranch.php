<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;

class RecordingBranch extends Model
{
    protected $table = 'calls_recording_branches';

    protected $fillable = ['recording_key', 'branch_id'];
}
