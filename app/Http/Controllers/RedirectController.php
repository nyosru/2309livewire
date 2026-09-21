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

        try {
            // Ищем его в базе данных
            $redirect = Redirect::where('get_param', $get)->firstOrFail();

            // Если запись найдена, перенаправляем на указанный URL
            // Записываем срабатывание редиректа
            RedirectHit::create([
                'redirect_id' => $redirect->id,
                'ip_address' => $request->ip(), // Получаем IP пользователя
                'hit_at' => now(),
            ]);

            return redirect()->to($redirect->url);
        } catch (\Exception $e) {
            Msg::sendTelegramm(
                '💋редирект / пустой гет параметр: '.$get
                .PHP_EOL.'https://php-cat.local/go/'.$get
            );
        }

        return redirect('/');
        // Если запись не найдена, возвращаем 404
        //        return abort(404, 'Redirect not found');
    }
}
