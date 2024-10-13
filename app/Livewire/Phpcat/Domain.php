<?php

namespace App\Livewire\Phpcat;

use App\Http\Controllers\Service\CaddyService;
use Illuminate\Http\Request;
use Livewire\Component;

class Domain extends Component {
    public $data_file = [];

    public function render( Request $request ) {
        $this->data_file = CaddyService::parseConfigFile( $request );

        return view('livewire.phpcat.domain');
    }
}
