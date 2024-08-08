<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ar_object_id',
        'ar_people_id',
        'price',
        'date_start',
        'opis'
    ];

    public function object()
    {
        return $this->belongsTo(ArObject::class);
    }

    public function man()
    {
        return $this->hasMany(ArPeople::class, 'id', 'ar_people_id');
    }
}
