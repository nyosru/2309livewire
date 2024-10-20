<?php

namespace App\Livewire\StNews\A;

use App\Http\Controllers\StNews\ParseController;
use Livewire\Component;

class StANewsItem extends Component
{
    public $news = [];
    public $data_parse = [];
    public $loading = false;

    public function parseNewsFull(){

        $this->loading=true;
//        if( empty($this->news) ){
//            // Сообщение об успешном добавлении
//            session()->flash('message', 'Сайт успешно добавлен!11');
//        }else{
//            // Сообщение об успешном добавлении
//            session()->flash('warn', 'Сайт успешно добавлен!22');
//        }

        $p = new ParseController();
        $parse_data = $p->loadParsingNewsItem($this->news);
        $this->data_parse = $p->saveParseNewsFullData($this->news,$parse_data);
        session()->flash('message', 'новсть успешно спарсена');
        $this->loading=false;
    }

    public function render()
    {
        return view('livewire.st-news.a.st-a-news-item');
    }
}
