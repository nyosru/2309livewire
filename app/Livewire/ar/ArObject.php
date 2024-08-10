<?php

namespace App\Livewire\Ar;

use Livewire\Component;
use App\Models\ArObject as ArObjectModel;

class ArObject extends Component
{
    public $object = null;
    public $deleted = false;

    public function delete(): void
    {
        ArObjectModel::find($this->object->id)->delete();
        $this->deleted = true;
    }

    public function render()
    {

        // Получаем объект с связанными данными о ценах, арендаторах и комментариях
        $object = ArObjectModel::with('prices.man.comments')->find($this->object->id);
        return view('livewire.ar.ar-object', [
            'object' => $object
        ]);
    }
}
