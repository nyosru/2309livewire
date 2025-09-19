<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


class Vk extends Component
{

    public function redir()
    {

        $clientId = config('services.vk.client_id');
        $redirectUri = config('services.vk.redirect');

        $authUrl = "https://oauth.vk.com/authorize?" . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'response_type' => 'code',
//                'scope' => 'email,messages,phone_number',
//                'scope' => 'email,messages',
//                'scope' => 'email,messages,wall,offline',
                'scope' => 'email',
                'v' => '5.131',
                'state' => csrf_token(),
            ]);
//dd($authUrl);
        return redirect()->away($authUrl);
//
//        $url = Socialite::driver('vk')
//            ->scopes('email')
//            ->stateless()
//            ->redirect()
//            ->getTargetUrl();
//
//        https://oauth.vk.com/authorize?client_id=ВАШ_ID&redirect_uri=ВАШ_REDIRECT_URI&response_type=code&scope=email&state=123123
//
//        dd($url);
//        return redirect()->away($url);

//
//        return Socialite::driver('vk')
//            ->scopes(['email'])
//            ->redirect();
////        dd( Socialite::driver('vk')->redirect() );
//        return Socialite::driver('vk')->redirect();
    }


    public function handleVKCallback()
    {
        try {
            if (!request()->has('code')) {
                throw new \Exception('Код авторизации не получен');
            }

            $code = request('code');

            // 1. Получаем access token
            $tokenResponse = Http::asForm()->post('https://oauth.vk.com/access_token', [
                'client_id' => config('services.vk.client_id'),
                'client_secret' => config('services.vk.client_secret'),
                'redirect_uri' => config('services.vk.redirect'),
                'code' => $code,
            ]);

            if ($tokenResponse->failed()) {
                throw new \Exception('Ошибка получения access token: ' . $tokenResponse->status());
            }

            $tokenData = $tokenResponse->json();

            if (isset($tokenData['error'])) {
                throw new \Exception('VK Error: ' . $tokenData['error_description'] . ' (' . $tokenData['error'] . ')');
            }

            // 2. Получаем информацию о пользователе
            $userResponse = Http::get('https://api.vk.com/method/users.get', [
                'access_token' => $tokenData['access_token'],
                'user_id' => $tokenData['user_id'],
                'fields' => 'first_name,last_name,photo_max_orig,screen_name',
                'v' => '5.131',
            ]);

            $userData = $userResponse->json();

            if (!isset($userData['response'][0])) {
                throw new \Exception('Данные пользователя не найдены');
            }

            $vkUser = $userData['response'][0];
            $email = $tokenData['email'] ?? ($tokenData['user_id'] . '@vk.com');
            $userId = $tokenData['user_id'];
            $accessToken = $tokenData['access_token']; // получаем токен

            // 3. Поиск или создание пользователя
            $user = User::where('vk_id', $userId)->first();

            if (!$user) {
                // Ищем по email если он есть
                if ($email && $email !== $userId . '@vk.com') {
                    $user = User::where('email', $email)->first();
                }

                // Создаем нового пользователя
                if (!$user) {
                    $user = User::create([
                        'name' => trim($vkUser['first_name'] . ' ' . $vkUser['last_name']),
                        'email' => $email,
                        'password' => bcrypt(uniqid()),
                        'vk_id' => $userId,
                        'vk_token' => $accessToken, // сохраняем токен
                    ]);
                } else {
                    // Обновляем существующего пользователя
                    $user->update([
                        'vk_id' => $userId,
                        'vk_token' => $accessToken, // сохраняем токен
                    ]);
                }
            } else {
                // Обновляем токен у существующего пользователя
                $user->update([
                    'vk_token' => $accessToken, // обновляем токен
                ]);
            }

            // 4. Логиним пользователя
            Auth::login($user, true);

//            $message = "🔔 Уведомление: 987";
//            $vkController = new \App\Http\Controllers\VkMessageController();
//            $vkController->sendNotification($user, $message);

            return redirect()->to('/');
//            return redirect()->route('tech.index');
//            return redirect()->route('board.list');
//            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            logger()->error('VK Auth Error: ' . $e->getMessage());
            session()->flash('error', 'Ошибка авторизации через VK: ' . $e->getMessage());
            return redirect()->route('login');
        }
    }



    public function render()
    {
        return view('livewire.auth.vk');
    }
}
