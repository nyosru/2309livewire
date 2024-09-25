<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class StNewsParsingSite extends Model
{
    use SoftDeletes;

    protected $table = 'st_news_parsing_site';
    // Если в вашей таблице есть поля created_at и updated_at, Eloquent автоматически управляет ими
    public $timestamps = true;
    protected $fillable = [
        'site_name',
        'site_url',
        'last_catalog_scan',
        'last_news_scan',
        'scan_status',
        'category_parsing_url',
        'time_to_auto_publish', // новое поле
    ];


    // Связь с новостями
    public function news()
    {
        return $this->hasMany(StNews::class, 'site_id');
    }

}
