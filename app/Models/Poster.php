<?php
// app/Models/Poster.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = [
        'title', 'description', 'link', 'event_date', 'event_time', 'end_date',
        'source_link', 'extra_links', 'images'
    ];

    protected $casts = [
        'extra_links' => 'array',
        'images' => 'array',  // Добавляем каст для хранения массива изображений
    ];
}
