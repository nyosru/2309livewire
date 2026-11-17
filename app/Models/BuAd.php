<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type_id', 'category_id', 'title', 'description',
        'price', 'contact_kind', 'contact_value', 'address', 'city',
        'status', 'is_approved', 'published_at', 'expires_at', 'ip', 'slug',
    ];
    protected $casts = [
        'id' => 'integer', 'user_id' => 'integer', 'type_id' => 'integer',
        'category_id' => 'integer', 'price' => 'decimal:2', 'views' => 'integer',
        'is_approved' => 'boolean', 'status' => 'string',
    ];
    protected $table = 'bu_ads';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(BuAdType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BuCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BuAdImage::class, 'ad_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(BuAdView::class, 'ad_id');
    }

    public function mainImage()
    {
        return $this->hasOne(BuAdImage::class, 'ad_id')->where('is_main', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
