<?php

namespace App\Livewire\StNews\Moderation;

use Livewire\Component;

class TextInputComponent extends Component
{
    public $url = '';
    public $iframeUrl = '';

    public function mount()
    {
        // Добавить начальную ссылку
        $this->url = 'https://stn.local/api/parse';
    }

//    public function render()
//    {
//        return view('livewire.text-input', [
//            'url' => $this->url
//        ]);
//    }

    public function onSubmit()
    {
//        $this->emit('showIframe', $this->url);
        $this->iframeUrl = $this->url;
    }
    public function render()
    {
        return view('livewire.st-news.moderation.text-input-component', [
            'url' => $this->url
        ]);
    }
}
