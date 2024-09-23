<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StNewsParsingCategory extends Model
{
    use HasFactory;

    protected $table = 'st_news_parsing_category';

    // Если в вашей таблице есть поля created_at и updated_at, Eloquent автоматически управляет ими
    public $timestamps = true;

    protected $fillable = [
        'site_id',
        'category_name',
        'category_url',
        'last_scan',
        'scan_status'
    ];
}
