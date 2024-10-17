<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DateService extends Controller
{
    static function convertDateTime($input)
    {
        // Массив для сопоставления русских названий месяцев с их числовыми значениями
        $months = [
            'января' => '01',
            'февраля' => '02',
            'марта' => '03',
            'апреля' => '04',
            'мая' => '05',
            'июня' => '06',
            'июля' => '07',
            'августа' => '08',
            'сентября' => '09',
            'октября' => '10',
            'ноября' => '11',
            'декабря' => '12'
        ];

        // Проверяем наличие года в строке через регулярное выражение
        if (preg_match('/(\d{1,2})\s([а-яА-Я]+)\s(\d{4}),\s(\d{2}:\d{2})/', $input, $matches)) {
            // Если год указан, извлекаем его
            [$full, $day, $month, $year, $time] = $matches;
        } else {
            // Если года нет, извлекаем день, месяц и время без года
            [$datePart, $timePart] = explode(',', $input);
            [$day, $month] = explode(' ', trim($datePart));
            $time = trim($timePart);
            $year = date('Y');  // Используем текущий год
        }

        // Приводим месяц к числовому виду
        $month = $months[mb_strtolower($month)];

        // Собираем финальную строку в формате Y-m-d H:i:s
        $formattedDateTime = "$year-$month-" . sprintf('%02d', $day) . " $time:00";

        return $formattedDateTime;
    }


}
