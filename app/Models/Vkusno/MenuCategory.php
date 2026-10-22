<?php

namespace App\Models\Vkusno;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    protected $table = 'vkusno_menu_categories';

    protected $guarded = ['id'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class, 'section_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'menu_category_id');
    }
}
