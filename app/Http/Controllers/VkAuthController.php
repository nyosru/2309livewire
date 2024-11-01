<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use VK\Client\VKApiClient;
#use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class VkAuthController extends Controller
{
    public function redirectToVk()
    {
        $apiClient = new VKApiClient();
        $oauthUrl = $apiClient->oauth()->getAuthorizeUrl(
            config('vk.app_id'),
            route('vk.callback'),
            ['email']
        );

        return redirect($oauthUrl);
    }

    public function handleVkCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('login')->withErrors(['error' => 'Authorization failed.']);
        }

        $code = $request->input('code');

        try {
            $apiClient = new VKApiClient();
            $accessTokenResponse = $apiClient->oauth()
                ->getAccessToken(config('vk.app_id'), config('vk.secret_key'), urlencode(route('vk.callback')), $code);

            $userInfo = $apiClient->users()->get([[
                'user_ids' => $accessTokenResponse['user_id'],
                'fields' => ['first_name', 'last_name', 'email'],
            ]]);

            // Найти или создать пользователя в вашей системе
            $vkUser = $userInfo[0];
            $localUser = User::where('email', $vkUser['email'])->first();

            if (!$localUser) {
                $localUser = new User;
                $localUser->name = $vkUser['first_name'] . ' ' . $vkUser['last_name'];
                $localUser->email = $vkUser['email'];
                $localUser->password = bcrypt(str_random(16)); // Генерируем случайный пароль
                $localUser->save();
            }

            Auth::login($localUser); // Авторизовать пользователя

            return redirect()->intended('/'); // Переадресация на главную страницу после успешной авторизации
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors(['message' => trans('auth.failed')]);
        }
    }
}
