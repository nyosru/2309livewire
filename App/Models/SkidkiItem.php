<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkidkiItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'date_start',
        'date_finish',
        'type',
        'phone',
        'author',
    ];

}
