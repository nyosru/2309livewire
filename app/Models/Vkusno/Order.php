<?php

namespace App\Models\Vkusno;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'vkusno_orders';

    protected $guarded = ['id'];

    protected $casts = [
        'items' => 'array',
        'cake' => 'array',
        'requested_date' => 'date',
    ];
}
