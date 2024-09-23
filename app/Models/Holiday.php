<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'holidays';

    protected $fillable = [
        'day',
        'month',
        'year',
        'title',
        'text',
        'country'
    ];

    public $timestamps = false;

    public $CountrysImg = [
        'Россия' => '/flag/russia.png',
        'Канада' => '/flag/canada.png',
        'Индия' => '/flag/indiya.png',
        'Международное' => '/flag/earth.png',
    ];


    public function getCountryStrAttribute()
    {
        return !empty($this->CountrysImg[$this->country]) ? '<img title="' . $this->country . '" src="' . $this->CountrysImg[$this->country] . '" />' : $this->country ?? '';
    }

    public function getCountryImgAttribute()
    {
        return !empty($this->CountrysImg[$this->country]) ? $this->CountrysImg[$this->country] : '';
    }

    /**
     * Запрос для получения событий, которые происходят сегодня и в ближайшие 20 дней.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        $today = now();
        $endDate = $today->copy()->addDays(35);

        return
            $query->where(function ($query) use ($today) {
                $query->where('month', '=', $today->month)
                    ->where('day', '>=', $today->day);
            })
                ->orWhere(function ($query) use ($today, $endDate) {
                    $query
                        ->where('month', '>', $today->month)
                        ->where('month', '<', $endDate->month);
                })
                ->orWhere(function ($query) use ($today, $endDate) {
                    $query
                        ->where('month', '>', $today->month)
                        ->where('month', '<=', $endDate->month)
                        ->where('day', '<=', $endDate->day);
                });
    }


}
