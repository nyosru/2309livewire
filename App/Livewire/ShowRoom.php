<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class ShowRoom extends Component
{
    public $imgs  = [];

    // #[Reactive]
    public $n  = '';

    public function setset($a){
        $this->n = $a;
        // $this->js("alert('Вы только что выполнили JS из бэкенда!".$a."')");
    }

    public function render()
    {
        return view('livewire.show-room');
    }
}
