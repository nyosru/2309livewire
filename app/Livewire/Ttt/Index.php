<?php

namespace App\Livewire\Ttt;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.ttt.index')
            ->layout('ttt.layouts.app');
    }
}
