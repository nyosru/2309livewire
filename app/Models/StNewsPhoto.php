<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StNewsPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'st_news_id',
        'newsstorage_news_id',
        'image_path',
        'local_photo', // Новое поле для локальной фотки
    ];

    public function news()
    {
        return $this->belongsTo(NewsStorageNews::class, 'newsstorage_news_id');
    }
}
