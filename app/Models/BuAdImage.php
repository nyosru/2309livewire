<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuAdImage extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'url', 'is_main', 'sort'];
    protected $casts = ['is_main' => 'boolean', 'sort' => 'integer', 'id' => 'integer', 'ad_id' => 'integer'];
    protected $table = 'bu_ad_images';

    public function ad(): BelongsTo
    {
        return $this->belongsTo(BuAd::class);
    }
}
