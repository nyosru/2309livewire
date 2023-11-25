<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArObject extends Model
{
    use HasFactory;

    public function prices()
    {
        return $this->hasMany(ArPrice::class, 'ar_object_id', 'id')->orderBy('date_start','desc');
    }

    public function payes()
    {
        return $this->hasMany(ArPay::class,'ar_object_id', 'id')->orderBy('date','desc');
    }

}
