<?php

namespace App\Livewire\Ar;

use Livewire\Component;

class ShowPriceItem extends Component
{
    public $data = [];
    public $payes = [];
    public $object_id;

    public function render()
    {
        return view('livewire.ar.show-price-item');
    }
}
