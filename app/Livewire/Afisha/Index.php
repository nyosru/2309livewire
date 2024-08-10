<?php

namespace App\Livewire\Afisha;

use App\Models\Poster;
use Livewire\Component;


class Index extends Component
{
    public $posters;

    public function mount()
    {
        // Загружаем афиши из базы данных
        $this->posters = Poster::all();
    }

    public function render()
    {
        return view(
            'livewire.afisha.index'
//            ,
//            [
//            'posters' => $this->posters, // Передаем афиши в шаблон
//        ]
        );
    }

}
