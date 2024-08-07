<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArPeople extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'ar_peoples';



    protected $fillable = [
        'name' ,
        'phone' ,
        'phone2' ,
        'opis'
    ];


    public function prices()
    {
        return $this->hasMany(ArPrice::class, 'ar_people_id', 'id');
    }

    public function payes()
    {
//        return $this->hasManyThrough(ArPay::class, ArPrice::class, 'ar_people_id', 'ar_object_id', 'id', 'ar_object_id');
        return $this->hasMany(ArPay::class, 'ar_people_id', 'id');
    }

}
