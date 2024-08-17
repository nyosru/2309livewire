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
        'published_at',
        'promo_code', // Добавляем это поле
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function photos()
    {
        return $this->hasMany(StNewsPhoto::class);
    }

    public function firstPhoto()
    {
        return $this->photos()->first();
    }
}
