<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zemOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'name',
        'city',
        'kooperativ',
        'nomer',
        'promo_code'
    ];

}
