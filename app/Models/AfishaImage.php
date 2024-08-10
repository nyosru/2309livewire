<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AfishaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'poster_id',
        'path',
    ];

    public function getUrlAttribute()
    {
        return Storage::url('afisha-img/' . $this->path);
    }

    public function poster()
    {
        return $this->belongsTo(AfishaPoster::class, 'poster_id');
    }
}
