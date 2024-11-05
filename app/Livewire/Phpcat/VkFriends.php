<?php

namespace App\Livewire\Phpcat;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class VkFriends extends Component
{
	public $friends = [];
	public $token;
	public $clientId;
	public $redirectUri;
	public $scope = 'friends';

	protected $listeners = [
		'refreshFriends' => '$refresh',
	];

	public function __construct()
	{
		$this->clientId = env('VK_CLIENT_ID');
		$this->redirectUri = env('VK_REDIRECT_URI2');
	}

	public function mount()
	{
		$this->getAccessToken();
	}

	public function getAuthorizationUrl()
	{
		return "https://oauth.vk.com/authorize?client_id={$this->clientId}&display=page&redirect_uri={$this->redirectUri}&scope={$this->scope}&response_type=code&v=5.131";
	}

	public function getAccessToken($code = null)
	{
		// Проверяем, есть ли код в сессии
		if (!session()->has('auth_code')) {
			if (!$code) {
				return redirect($this->getAuthorizationUrl());
			}

			// Сохраняем код в сессию
			session(['auth_code' => $code]);
		}

		// Используем код из сессии
		$code = session('auth_code');

		$response = Http::asForm()->post('https://oauth.vk.com/access_token', [
			'client_id' => $this->clientId,
			'client_secret' => config('services.vk.secret'),
			'redirect_uri' => $this->redirectUri,
			'code' => $code,
		]);

		if ($response->successful()) {
			$data = $response->json();
			$this->token = $data['access_token'];
			$this->getFriends();
		} else {
			session()->flash('error', 'Ошибка получения токена.');
		}
	}

	public function getFriends()
	{
		// Получаем список друзей через API VK
		$response = Http::withToken($this->token)->get('https://api.vk.com/method/friends.get', [
			'order' => 'hints',
			'fields' => 'nickname,photo_100',
			'v' => '5.131'
		]);

		if ($response->successful()) {
			$data = $response->json()['response']['items'];
			foreach ($data as &$friend) {
				$friend['id'] = $friend['id'];
				$friend['first_name'] = $friend['first_name'];
				$friend['last_name'] = $friend['last_name'];
				$friend['photo_url'] = $friend['photo_100'];
			}
			$this->friends = $data;
		} else {
			session()->flash('error', 'Не удалось получить список друзей.');
		}
	}

	public function deleteFriend($friendId)
	{
		// Удаление друга в подписчики
		$response = Http::withToken($this->token)->post('https://api.vk.com/method/friends.delete', [
			'user_id' => $friendId,
			'v' => '5.131'
		]);

		if ($response->successful() && $response->json()['response']) {
			session()->flash('message', 'Друг успешно удален.');
			$this->emit('refreshFriends');
		} else {
			session()->flash('error', 'Произошла ошибка при удалении друга.');
		}
	}

	public function render()
	{
		return view('livewire.phpcat.vk-friends');
	}
}
