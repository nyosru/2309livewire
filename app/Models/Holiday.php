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

    public function getCountryStrAttribute(){
        $img = '';
        if( $this->country == 'Россия' ){ $img = 'russia.png'; }
        else if( $this->country == 'Канада' ){ $img = 'canada.png'; }
        else if( $this->country == 'Индия' ){ $img = 'indiya.png'; }

        return !empty($img) ? ( '<img title="'.$this->country.'" src="/flag/'.$img.'" />' ) : $this->country;
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
                ->orWhere(function ($query) use ($endDate) {
                    $query->where('month', '=', $endDate->month)
                        ->where('day', '<=', $endDate->day);
                });
    }


}
