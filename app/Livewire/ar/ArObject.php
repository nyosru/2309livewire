<?php

namespace App\Livewire\Ar;

use Livewire\Component;

class ArObject extends Component
{

    public $object = null;
    public $deleted = false;


    public function delete():void{
        \App\Models\ArObject::find($this->object->id)->delete();
        $this->deleted = true;
    }


    public function render()
    {
        return view('livewire.ar.ar-object');
    }
}
