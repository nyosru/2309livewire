<?php

namespace App\Livewire\Zem_kadastr;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.zem_kadastr.index')
            ->layout('livewire.zem_kadastr.app.body');
    }
}
