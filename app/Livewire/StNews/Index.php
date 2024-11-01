<?php

namespace App\Livewire\StNews;

use Livewire\Component;
use Laravel\Socialite\Facades\Socialite;

class Index extends Component
{

    public $uuser;
//    public $user;

    public function mount(){
//        $user = Socialite::driver('vkontakte')->user();
//        $this->uuser = $user->getName();
        $this->uuser = auth()->user(); // Получаем текущего авторизованного пользователя
//        $this->user = auth()->user(); // Получаем текущего авторизованного пользователя
    }

    public function render()
    {


        return view('livewire.st-news.index');
    }
}
