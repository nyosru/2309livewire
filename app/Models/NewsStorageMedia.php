<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsStorageMedia extends Model
{
    use HasFactory;

    protected $connection = 'newsstorage';
    protected $table = 'newsstorage_media';

    protected $fillable = [
        'news_id',
        'url',
        'type',
    ];

    public function news()
    {
        return $this->belongsTo(NewsStorageNews::class, 'news_id');
    }
}
