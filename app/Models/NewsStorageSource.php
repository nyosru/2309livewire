<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsStorageSource extends Model
{
    use HasFactory;

    protected $connection = 'newsstorage';
    protected $table = 'newsstorage_sources';

    protected $fillable = [
        'name',
        'url',
        'parsing_instructions',
        'last_catalog_scan',
    ];

    protected $casts = [
        'last_catalog_scan' => 'datetime',
    ];

    public function news()
    {
        return $this->hasMany(NewsStorageNews::class, 'source_id');
    }
}
