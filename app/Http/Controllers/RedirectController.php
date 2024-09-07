<?php

namespace App\Http\Controllers;

use App\Models\Redirect;
use App\Models\RedirectHit;
use Illuminate\Http\Request;
use Nyos\Msg;

class RedirectController extends Controller
{
    public function __invoke($get, Request $request)
    {
        // Получаем GET-параметр из запроса
//        $getParam = $request->query('key'); // Параметр "key" замените на нужный

        // Ищем его в базе данных
        $redirect = Redirect::where('get_param', $get)->first();
        Msg::sendTelegramm('редирект - гет параметр - '.$get );

        // Если запись найдена, перенаправляем на указанный URL
        if ($redirect) {
            // Записываем срабатывание редиректа
            RedirectHit::create([
                'redirect_id' => $redirect->id,
                'ip_address' => $request->ip(), // Получаем IP пользователя
                'hit_at' => now()
            ]);

            return redirect()->to($redirect->url);
        }

        // Если запись не найдена, возвращаем 404
        return abort(404, 'Redirect not found');
    }
}
