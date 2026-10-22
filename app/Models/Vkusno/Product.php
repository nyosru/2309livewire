<?php

namespace App\Models\Vkusno;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'vkusno_products';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $hidden = ['is_active', 'sort_order', 'created_at', 'updated_at', 'menu_category_id'];

    protected $casts = [
        'price' => 'integer',
        'inferred_fields' => 'array',
        'price_is_estimate' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function menuCategory(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->active()->whereHas('menuCategory', fn (Builder $category) => $category
            ->where('is_active', true)
            ->whereHas('section', fn (Builder $section) => $section->where('is_active', true)));
    }
}
