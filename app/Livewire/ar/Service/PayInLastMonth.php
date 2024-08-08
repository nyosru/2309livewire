<?php

namespace App\Livewire\Ar\Service;

use Livewire\Component;
use Carbon\Carbon;

class PayInLastMonth extends Component
{
    public $date_pay;
    public $diff = false;

    public function mount($date_pay)
    {
        $this->date_pay = $date_pay;
        $this->checkIfDateInCurrentMonth();
    }

    public function checkIfDateInCurrentMonth()
    {
        $date = Carbon::parse($this->date_pay);
        $currentMonth = Carbon::now()->format('Y-m');

        if ($date->format('Y-m') === $currentMonth) {
            $this->diff = true;
        }
    }

    public function render()
    {
        return view('livewire.ar.service.pay-in-last-month');
    }
}
