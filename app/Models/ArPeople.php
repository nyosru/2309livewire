<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArPeople extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ar_peoples'; // Указываем правильное имя таблицы

    protected $fillable = [
        'name',
        'phone',
        'opis'
    ];


//    public function payes()
//    {
//        return $this->hasMany(ArPay::class, 'ar_object_id', 'id')->orderBy('date', 'desc');
//    }
    public function payes()
    {
        return $this->hasMany(ArPay::class, 'ar_people_id', 'id');
    }

    // Связь с комментариями
    public function comments()
    {
        return $this->hasMany(ArComment::class, 'ar_people_id');
    }
}
