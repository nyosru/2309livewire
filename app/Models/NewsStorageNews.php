<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsStorageNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'newsstorage';
    protected $table = 'newsstorage_news';

    protected $fillable = [
        'source_id',
        'url',
        'title',
        'summary',
        'content',
        'status',
    ];

    public function source()
    {
        return $this->belongsTo(NewsStorageSource::class, 'source_id');
    }

    public function media()
    {
        return $this->hasMany(NewsStorageMedia::class, 'news_id');
    }
}
