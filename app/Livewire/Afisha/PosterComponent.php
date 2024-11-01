<?php

namespace App\Livewire\Afisha;

use Livewire\Component;
use App\Models\AfishaPoster as Poster;
use Carbon\Carbon;

class PosterComponent extends Component
{
    public $posters;

    public function mount()
    {
        $currentDate = Carbon::now();

        $this->posters = Poster::where(function($query) use ($currentDate) {
            $query->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                    ->where('event_date', '>=', $currentDate);
            })
                ->orWhere(function($query) use ($currentDate) {
                    $query->whereNotNull('end_date')
                        ->where('end_date', '>=', $currentDate);
                });
        })->orderBy('event_date')->orderBy('event_time')
            ->get()
            ->map(function($poster) {
            // Преобразование строковых дат в объекты Carbon
            $dn = date('w', strtotime(Carbon::parse($poster->event_date)));
            if( $dn == 0 ){ $poster->dn = 'Воскресенье'; }
            elseif( $dn == 1 ){ $poster->dn = 'Понедельник'; }
            elseif( $dn == 2 ){ $poster->dn = 'Вторник'; }
            elseif( $dn == 3 ){ $poster->dn = 'Среда'; }
            elseif( $dn == 4 ){ $poster->dn = 'Четверг'; }
            elseif( $dn == 5 ){ $poster->dn = 'Пятница'; }
            elseif( $dn == 6 ){ $poster->dn = 'Суббота'; }

            $poster->event_date = Carbon::parse($poster->event_date);
            if ($poster->end_date) {
                $poster->end_date = Carbon::parse($poster->end_date);
            }
            return $poster;
        });
    }

    public function render()
    {
        return view('livewire.afisha.poster-component');
    }
}
