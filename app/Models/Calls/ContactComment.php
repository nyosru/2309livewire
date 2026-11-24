<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactComment extends Model
{
    protected $table = 'calls_contact_comments';

    protected $fillable = ['body'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
