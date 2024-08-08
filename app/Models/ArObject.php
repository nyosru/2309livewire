<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        return $this->hasMany(ArPrice::class, 'ar_object_id', 'id')->orderBy('date_start','desc');
    }

    public function payes()
    {
        return $this->hasMany(ArPay::class,'ar_object_id', 'id')->orderBy('date','desc');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($arObject) {
            if ($arObject->isForceDeleting()) {
                $arObject->prices()->forceDelete();
                $arObject->payes()->forceDelete();
            } else {
                $arObject->prices()->delete();
                $arObject->payes()->delete();
            }
        });

        static::restoring(function ($arObject) {
            $arObject->prices()->withTrashed()->whereNotNull('deleted_at')->restore();
            $arObject->payes()->withTrashed()->whereNotNull('deleted_at')->restore();
        });
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
