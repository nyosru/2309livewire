<?php

namespace App\Livewire\Catcom;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.catcom.index')
            ->layout('livewire.catcom.app.body');
    }
}
