<?php

namespace App\Livewire\Skidki;

use Livewire\Component;

class Index extends Component
{

    public $pass = '';
    public function render()
    {
        return view('livewire.skidki.index');
    }
}
