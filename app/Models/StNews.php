<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Подключение Soft Deletes

class StNews extends Model
{
    use HasFactory, SoftDeletes; // Используем SoftDeletes

    protected $fillable = [
        'title',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime', // Автоматическое приведение к Carbon/DateTime
    ];

    public function photos()
    {
        return $this->hasMany(StNewsPhoto::class);
    }

    public function firstPhoto()
    {
        // Метод возвращает первую связанную фотографию
        return $this->photos()->first();
    }
}
