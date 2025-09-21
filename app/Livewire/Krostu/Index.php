<?php

namespace App\Livewire\Krostu;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.krostu.index')
            ->layout('livewire.krostu.app.body');
    }
}
