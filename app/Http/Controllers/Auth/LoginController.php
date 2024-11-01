<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;

use Laravel\Socialite\Two\InvalidStateException;
use Exception;

use VK\Actions\Auth;
use Psy\Util\Str;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('vkontakte')->redirect();
//        return Socialite::redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('vkontakte')->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        // Проверяем, существует ли пользователь в нашей базе данных
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            // Обновляем токен доступа
            $existingUser->update([
                'vk_access_token' => $user->token,
            ]);

            // Авторизуемся
            Auth::login($existingUser);
        } else {
            // Создаем нового пользователя
            $newUser = new User;
            $newUser->name = $user->getName();
            $newUser->email = $user->getEmail();
            $newUser->password = Hash::make(Str::random(16));
            $newUser->vk_access_token = $user->token;
            $newUser->save();

            // Авторизация нового пользователя
            Auth::loginUsingId($newUser->id);
        }

        return redirect()->intended('/');
    }
}
