<?php
// app/Models/AfishaPoster.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfishaPoster extends Model
{
    use HasFactory;

    // Указываем таблицу, которую будет использовать модель
    protected $table = 'afisha_posters';

    protected $fillable = [
        'title', 'description', 'link', 'event_date', 'event_time', 'end_date',
        'source_link', 'extra_links', 'images'
    ];

    protected $casts = [
        'extra_links' => 'array',
        // 'images' => 'array',  // Убрано, т.к. используется отношение hasMany
    ];

    // Определяем отношение hasMany к модели AfishaImage
    public function images()
    {
        return $this->hasMany(AfishaImage::class, 'poster_id');
    }
}
