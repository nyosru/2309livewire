<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StNewsPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['st_news_id', 'image_path'];

    public function news()
    {
        return $this->belongsTo(StNews::class, 'st_news_id');
    }
}
