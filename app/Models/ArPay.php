<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArPay extends Model
{
    use HasFactory;


    protected $fillable = [
        'ar_object_id',
        'ar_people_id',
        'amount',
        'date',
        'opis',
        'json'
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'ar_pays';

    public function object()
    {
        return $this->belongsTo(ArObject::class);
    }

}
