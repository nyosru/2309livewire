<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhpcatRentalSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'category',
        'description',
        'is_rented',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_rented' => 'boolean',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function url(): string
    {
        return 'https://'.$this->domain;
    }
}
