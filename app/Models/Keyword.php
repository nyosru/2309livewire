<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Ключевое слово новости (лемма существительного / глагола).
 * Связь many-to-many с StNews через st_news_keywords.
 */
class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'news_count',
    ];

    protected $casts = [
        'news_count' => 'integer',
    ];

    /** Новости, в которых встречается это слово. */
    public function news()
    {
        return $this->belongsToMany(StNews::class, 'st_news_keywords');
    }

    /** Синхронизировать денормализованный счётчик новостей после изменения связей. */
    public function syncNewsCount(): void
    {
        $this->update(['news_count' => $this->news()->count()]);
    }
}
