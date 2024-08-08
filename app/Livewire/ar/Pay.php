<?php

namespace App\Livewire\Ar;

use App\Models\ArPay;
use Livewire\Component;

class Pay extends Component
{
    public $pay = [];
    public $deleted = false;

    public function delete(){
        ArPay::find($this->pay->id)->delete();
        $this->deleted = true;
    }

    public function render()
    {
        return view('livewire.ar.pay');
    }
}
