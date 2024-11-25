<?php

namespace App\Livewire\Phpcatru;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.phpcatru.index-component')
            ->layout('livewire.phpcatru.layouts.app-component', [
//                'title' => 'Мой заголовок', // Передача данных в родительский шаблон
                // 'slot' => 'main-content', // Указать, какой слот использовать
            ]);
    }
}
