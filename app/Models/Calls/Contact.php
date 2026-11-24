<?php

namespace App\Models\Calls;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $table = 'calls_contacts';

    protected $fillable = ['phone', 'phone_normalized', 'name'];

    public function comments(): HasMany
    {
        return $this->hasMany(ContactComment::class, 'contact_id')->latest();
    }
}
