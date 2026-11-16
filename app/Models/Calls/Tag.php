<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $table = 'calls_tags';

    protected $fillable = ['name'];

    public function recordingTags(): HasMany
    {
        return $this->hasMany(RecordingTag::class, 'tag_id');
    }
}
