<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArPay extends Model
{
    use HasFactory, SoftDeletes;

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
