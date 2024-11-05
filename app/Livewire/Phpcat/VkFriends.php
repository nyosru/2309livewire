<?php

namespace App\Livewire\Phpcat;

use Livewire\Component;

class VkFriends extends Component
{
	public $friends = [];
	public $token;
	static public $clientId;
	static public $redirectUri;
	static public $scope = 'friends';

	protected $listeners = [
		'refreshFriends' => '$refresh',
	];

//	public function mount($clientId, $redirectUri)
	public function mount()
	{
//		$this->clientId = $clientId;
		self::$clientId = env('VK_CLIENT_ID' );
//		$this->redirectUri = $redirectUri;
		self::$redirectUri = env('VK_REDIRECT_URI2');
		self::getAccessToken();
	}

	static public function getAuthorizationUrl()
	{
		return 'https://oauth.vk.com/authorize?client_id='.self::$clientId.'&display=page&redirect_uri='.self::$redirectUri.'&scope='.self::$scope.'&response_type=code&v=5.131';
	}

	static public function getAccessToken($code = null)
	{
		if (!$code) {
			return redirect(self::getAuthorizationUrl());
		}

		$response = Http::asForm()->post('https://oauth.vk.com/access_token', [
			'client_id' => self::$clientId,
			'client_secret' => env('VK_CLIENT_SECRET'),
			'redirect_uri' => self::$redirectUri,
			'code' => $code,
		]);

		if ($response->successful()) {
			$data = $response->json();
			self::$token = $data['access_token'];
			self::getFriends();
		} else {
			session()->flash('error', 'Ошибка получения токена.');
		}
	}

	static public function getFriends()
	{
		// Получаем список друзей через API VK
		$response = Http::withToken(self::$token)->get('https://api.vk.com/method/friends.get', [
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
			self::$friends = $data;
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
