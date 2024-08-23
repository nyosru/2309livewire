<?php

namespace App\Livewire\Afisha;

use Livewire\Component;
use App\Models\Holiday;
use Carbon\Carbon;

class HolidaysList extends Component
{
    public $holidays;

    public function mount()
    {
        $this->holidays = Holiday::upcoming()->orderBy('month')->orderBy('day')->get();
    }

    public function render()
    {
        return view('livewire.afisha.holidays-list');
    }
}
