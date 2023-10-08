<?php

namespace App\Livewire\Uprav;

use Livewire\Component;

class UpravIndex extends Component
{
    public function render()
    {
        return view('livewire.uprav.uprav-index')
            ->layout('uprav.layouts.app');
    }
}
