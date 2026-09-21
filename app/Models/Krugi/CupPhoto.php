<?php

namespace App\Models\Krugi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cup_id',
        'image',
        'link',
        'sort',
    ];

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function getUrlAttribute(): string
    {
        return $this->link ?: '/storage/krugi/cups/'.$this->image;
    }

    public function getMiniUrlAttribute(): string
    {
        return $this->link ?: '/storage/krugi/cups/mini/'.$this->image;
    }
}
