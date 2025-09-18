<?php

namespace App\Livewire\Cfa;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.cfa.index')
            ->layout('livewire.cfa.app.body');
    }
}
