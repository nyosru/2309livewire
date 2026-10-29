<?php

namespace App\Models\Cals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $table = 'cals_contacts';

    protected $fillable = ['name', 'phone', 'phone_normalized', 'company_name', 'start_date', 'notes'];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
    ];

    public function calls(): HasMany
    {
        return $this->hasMany(Call::class, 'contact_id')->orderBy('call_at')->orderBy('id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ContactComment::class, 'contact_id')->latest();
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: ($this->phone ?: 'Контакт без имени');
    }
}
