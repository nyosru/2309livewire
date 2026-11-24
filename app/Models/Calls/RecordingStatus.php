<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;

class RecordingStatus extends Model
{
    protected $table = 'calls_recording_statuses';

    protected $fillable = ['recording_key', 'status'];
}
