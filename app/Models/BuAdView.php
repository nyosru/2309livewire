<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuAdView extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'ip'];
    protected $casts = ['id' => 'integer', 'ad_id' => 'integer'];
    protected $table = 'bu_ad_views';

    public function ad(): BelongsTo
    {
        return $this->belongsTo(BuAd::class, 'ad_id');
    }
}
