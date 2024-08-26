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
        })->get()->map(function($poster) {
            // Преобразование строковых дат в объекты Carbon
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
