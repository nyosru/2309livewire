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
            ->map(function($poster) use ($currentDate)  {

                // Определение дня недели на русском
                $dn = Carbon::parse($poster->event_date)->dayOfWeek;
                $daysOfWeek = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
                $poster->dn = $daysOfWeek[$dn];


            $poster->event_date = Carbon::parse($poster->event_date);
            if ($poster->end_date) {
                $poster->end_date = Carbon::parse($poster->end_date);
            }

                // Определение значения для поля relativeDate
                if ($poster->event_date->isSameDay($currentDate)) {
                    $poster->relativeDate = 'Сегодня';
                } elseif ($poster->event_date->isSameDay($currentDate->copy()->addDay())) {
                    $poster->relativeDate = 'Завтра';
                } elseif ($poster->event_date->isSameDay($currentDate->copy()->addDays(2))) {
                    $poster->relativeDate = 'Послезавтра';
                } else {
                    $poster->relativeDate = null; // Не показывать ничего, если дата не соответствует
                }

                return $poster;
        });
    }

    public function render()
    {
        return view('livewire.afisha.poster-component');
    }
}
