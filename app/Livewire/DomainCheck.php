<?php

namespace App\Livewire;

use App\Http\Controllers\Service\DomainService;
use Livewire\Component;

class DomainCheck extends Component
{
    public $domain = '';

    public $domain_check = [];

    public function render()
    {

        if (strpos(strtolower($this->domain), '.local') !== false || strpos(strtolower($this->domain), '*') !== false || strpos(strtolower($this->domain), ':') !== false) {
        } else {
            $this->domain_check = DomainService::checkDomains([$this->domain]);
        }

        return view('livewire.domain-check');
    }
}
