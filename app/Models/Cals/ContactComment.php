<?php

namespace App\Models\Cals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactComment extends Model
{
    protected $table = 'cals_contact_comments';

    protected $fillable = ['contact_id', 'body'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
