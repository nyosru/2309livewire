<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArObject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomer',
        'adres',
        'opis',
    ];

    public function prices()
    {
        return $this->hasMany(ArPrice::class, 'ar_object_id', 'id')->orderBy('date_start', 'desc');
    }

    public function payes()
    {
        return $this->hasMany(ArPay::class, 'ar_object_id', 'id')->orderBy('date', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(ArComment::class, 'ar_object_id', 'id');
    }

    public function getPayInMonthAttribute()
    {
        $latestPay = $this->prices->flatMap(function($price) {
            return $price->man->flatMap(function($man) {
                return $man->payes;
            });
        })->sortByDesc('date')->first();

        return $latestPay && Carbon::parse($latestPay->date)->greaterThanOrEqualTo(Carbon::now()->subDays(30));
    }
}
