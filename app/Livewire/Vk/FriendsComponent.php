<?php

namespace App\Livewire\Vk;

use Livewire\Component;
use VK\Client\VKApiClient;
use Illuminate\Support\Facades\Auth;

class FriendsComponent extends Component
{
    public $friends = [];

    protected $listeners = ['refreshFriends' => '$refresh'];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Получаем токен доступа к аккаунту ВК
        $accessToken = Auth::user()->vk_access_token;

        if ($accessToken) {
            try {
                $client = new VKApiClient();
                $response = $client->friends()->get([
                    'user_id' => Auth::id(),
                    'fields' => ['first_name', 'last_name', 'photo_100'],
                    'access_token' => $accessToken,
                ]);

                $this->friends = $response['items'] ?? [];
            } catch (\Exception $e) {
                session()->flash('error', 'Ошибка при получении списка друзей.');
            }
        }
    }

    public function render()
    {
        return view('livewire.friends-component');
    }
}
