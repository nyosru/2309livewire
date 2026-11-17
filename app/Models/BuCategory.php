<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id', 'level', 'title', 'slug', 'description',
        'icon', 'sort', 'is_active', 'meta_title', 'meta_description',
    ];
    protected $casts = [
        'id' => 'integer', 'parent_id' => 'integer', 'level' => 'integer',
        'sort' => 'integer', 'is_active' => 'boolean',
    ];
    protected $table = 'bu_categories';

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(BuAd::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function fullPath(): string
    {
        $parts = [$this->title];
        $parent = $this->parent;
        while ($parent !== null) {
            array_unshift($parts, $parent->title);
            $parent = $parent->parent;
        }
        return implode(' / ', $parts);
    }
}
