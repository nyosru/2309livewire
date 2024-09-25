<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StNews extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'source',
        'published_at',
        'promo_code',
        'moderation_required',
        'told_at',
        'cat_id', // Добавляем это поле для заполнения
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Связь с моделью StNewsParsingCategory
    public function category()
    {
        return $this->belongsTo(StNewsParsingCategory::class, 'cat_id');
    }

    // Связь с моделью StNewsParsingSite
    public function site()
    {
        return $this->belongsTo(StNewsParsingSite::class, 'site_id');
    }

    public function photos()
    {
        return $this->hasMany(StNewsPhoto::class);
    }

    public function firstPhoto()
    {
        return $this->photos()->first();
    }
}
