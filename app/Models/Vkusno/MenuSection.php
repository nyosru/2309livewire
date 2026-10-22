<?php

namespace App\Models\Vkusno;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuSection extends Model
{
    protected $table = 'vkusno_menu_sections';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function categories(): HasMany
    {
        return $this->hasMany(MenuCategory::class, 'section_id');
    }
}
