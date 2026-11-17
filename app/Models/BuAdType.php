<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuAdType extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title_ru', 'icon', 'is_visible', 'sort'];
    protected $casts = ['is_visible' => 'boolean', 'sort' => 'integer', 'id' => 'integer'];
    protected $table = 'bu_ad_types';

    public function ads(): HasMany
    {
        return $this->hasMany(BuAd::class);
    }

    public static function buy(): self
    {
        return static::firstOrCreate(['slug' => 'buy'], ['title_ru' => 'Куплю', 'icon' => 'bi-cart-plus']);
    }

    public static function sell(): self
    {
        return static::firstOrCreate(['slug' => 'sell'], ['title_ru' => 'Продам', 'icon' => 'bi-cart-dash']);
    }
}
