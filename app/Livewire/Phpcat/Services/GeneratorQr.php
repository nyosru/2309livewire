<?php

namespace App\Livewire\Phpcat\Services;

use Livewire\Component;

class GeneratorQr extends Component
{
	public $text ='';
	public $img ='';
	public $img_url ='';

	public function generate(){
		$this->img_url = $this->text;
		$this->img = '/api/qr?uri='.$this->text;
	}

	public function render()
    {
        return view('livewire.phpcat.services.generator-qr');
    }
}
