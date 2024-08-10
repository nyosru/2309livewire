<?php
namespace App\Livewire\Afisha;

use Livewire\Component;
use App\Models\Poster;
use Carbon\Carbon;

class PosterComponent extends Component
{
    public $posters;

    public function mount()
    {
        $this->posters = Poster::all()->map(function($poster) {
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
