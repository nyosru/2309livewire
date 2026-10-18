<?php

namespace App\Models\Krugi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'lat',
        'lon',
        'address',
        'opis',
        'advertising_text',
        'advertising_address',
        'advertising_phone',
        'show_advertisement',
        'is_hidden',
    ];

    protected $casts = [
        'show_advertisement' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(CupPhoto::class)->orderBy('sort');
    }

    public function firstPhoto(): ?CupPhoto
    {
        return $this->photos->first();
    }
}
