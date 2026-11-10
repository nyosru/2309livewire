<?php

namespace App\Livewire\Auth;

use App\Models\NewsStorageAdministrator;
use App\Services\VkAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;

class Vk extends Component
{
    public function redir()
    {

        $clientId = config('services.vk.client_id');
        $redirectUri = config('services.vk.redirect');
        $state = Str::random(40);
        session()->put('vk_oauth_state', $state);

        $authUrl = 'https://oauth.vk.com/authorize?'.http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            //                'scope' => 'email,messages,phone_number',
            //                'scope' => 'email,messages',
            //                'scope' => 'email,messages,wall,offline',
            'scope' => 'email',
            'v' => '5.131',
            'state' => $state,
        ]);

        // dd($authUrl);
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
        // //        dd( Socialite::driver('vk')->redirect() );
        //        return Socialite::driver('vk')->redirect();
    }

    public function handleVKCallback()
    {
        try {
            $state = session()->pull('vk_oauth_state');
            if (! is_string($state) || ! is_string(request('state')) || ! hash_equals($state, request('state'))) {
                throw new \Exception('Проверка состояния авторизации не пройдена');
            }

            if (! request()->has('code')) {
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
                throw new \Exception('Ошибка получения access token: '.$tokenResponse->status());
            }

            $tokenData = $tokenResponse->json();

            if (isset($tokenData['error'])) {
                throw new \Exception('VK Error: '.$tokenData['error_description'].' ('.$tokenData['error'].')');
            }

            // 2. Получаем информацию о пользователе
            $userResponse = Http::get('https://api.vk.com/method/users.get', [
                'access_token' => $tokenData['access_token'],
                'user_id' => $tokenData['user_id'],
                'fields' => 'first_name,last_name,photo_max_orig,screen_name',
                'v' => '5.131',
            ]);

            $userData = $userResponse->json();

            if (! isset($userData['response'][0])) {
                throw new \Exception('Данные пользователя не найдены');
            }

            $vkUser = $userData['response'][0];
            $email = $tokenData['email'] ?? ($tokenData['user_id'].'@vk.com');
            $userId = $tokenData['user_id'];
            $accessToken = $tokenData['access_token']; // получаем токен

            // 3. Единый сервис авторизации: та же схема, что используется в master.local.
            $user = app(VkAuthService::class)->findOrCreateUser(
                $userId,
                $accessToken,
                $email,
                trim($vkUser['first_name'].' '.$vkUser['last_name']),
            );

            // 4. Логиним пользователя
            Auth::login($user, true);
            session()->regenerate();
            session()->forget('vk_auth_error_redirect');

            // Вход из админки news.local дополнительно регистрирует запрос доступа.
            if (session()->pull('news_storage_admin_login', false)) {
                NewsStorageAdministrator::registerLogin($user);

                return redirect('/admin');
            }

            //            $message = "🔔 Уведомление: 987";
            //            $vkController = new \App\Http\Controllers\VkMessageController();
            //            $vkController->sendNotification($user, $message);

            return redirect()->intended('/');
            //            return redirect()->route('tech.index');
            //            return redirect()->route('board.list');
            //            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            logger()->error('VK Auth Error: '.$e->getMessage());
            session()->flash('error', 'Не удалось войти через ВКонтакте. Попробуйте ещё раз.');

            return redirect()->to(session()->pull('vk_auth_error_redirect', route('login')));
        }
    }

    public function render()
    {
        return view('livewire.auth.vk');
    }
}
