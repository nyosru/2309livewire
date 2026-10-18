<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'location',
        'status',
        'status_color',
        'description',
        'investment_offer',
        'images',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
