<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordingTag extends Model
{
    protected $table = 'calls_recording_tags';

    protected $fillable = ['recording_basename', 'tag_id'];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
