<?php

namespace App\Livewire\StNews\Moderation;

use Livewire\Component;

class IFrameComponent extends Component
{
//    protected $listeners = ['showIframe' => 'onShowIframe'];

    private $iframeUrl = '';

    public function onShowIframe($url)
    {
        $this->iframeUrl = $url;
        $this->render();
    }

//    public function render()
//    {
//        return view('livewire.iframe', [
//            'iframeUrl' => $this->iframeUrl
//        ]);
//    }
    public function render()
    {
        return view('livewire.st-news.moderation.i-frame-component', [
            'iframeUrl' => $this->iframeUrl
        ]);
    }
}
