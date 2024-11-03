<?php

namespace App\Livewire\Phpcat\Services;

use Livewire\Component;

class Index extends Component
{
	public $selectedComponent = '';

    public function render()
    {
        return view('livewire.phpcat.services.index');
    }
}
