<?php

namespace App\Livewire\Helper;

use Livewire\Component;

class ShowerDopInfo extends Component
{
    public $string = '';
    public $data = [];
    public $show = false;


    public function switcher(){
        $this->show = !$this->show;
    }

    public function render()
    {
        return view('livewire.helper.shower-dop-info');
    }
}
