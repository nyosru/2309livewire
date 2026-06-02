<?php

namespace App\Livewire\NewsStorage;

use Livewire\Component;

class ApiDocs extends Component
{
    public function render()
    {
        return view('livewire.news-storage.api-docs')
            ->layout('livewire.news-storage.layouts.app-component', [
                'title' => 'API Documentation — News Storage'
            ]);
    }
}
