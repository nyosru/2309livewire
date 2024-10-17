<?php

namespace App\Services\StNews;

use App\Models\StNewsPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsPhotoService
{
    public $dir_for_photo = 'st_news_photos';

    /**
     * Максимальное время общей загрузки фото
     * @var int
     */
    public $maxExecutionTime = 10; // 10 секунд

    /**
     * Максимальное время для загрузки одного фото
     * @var int
     */
    public $maxSingleDownloadTime = 3; // 3 секунды

    /**
     * Скачивает фото новостей и добавляет ссылку на локальное фото в ту же запись
     *
     * @return array
     */
    public function downloadAndStorePhotos()
    {
        $return = [
            'log' => [],
            'loaded_size' => 0
        ];

        // Ограничение времени выполнения скрипта
        $maxExecutionTime = $this->maxExecutionTime;
        $startTime = microtime(true); // Старт времени

        // Получаем все записи из таблицы st_news_photos, у которых нет локальной копии
        $photos = StNewsPhoto::whereNull('local_photo')->get();

        $return['all_web_photo'] = count($photos);
        $return['loaded'] = [];

        foreach ($photos as $photo) {

            // Проверяем общее время выполнения, если больше 10 секунд - прерываем
            if ((microtime(true) - $startTime) > $maxExecutionTime) {
                $return['log'][] = 'Превышено общее время выполнения скрипта, загрузка остановлена.';
                break;
            }

            // Логирование общего времени выполнения
            $return['log'][] = "Время выполнения на текущий момент: " . (microtime(true) - $startTime) . " секунд.";

            // Предполагаем, что поле 'image_path' содержит ссылку на фото
            $imagePath = $photo->image_path;
            $return['loaded'][] = $imagePath;

            try {
                // Засекаем время начала загрузки конкретного фото
                $singleStartTime = microtime(true);

                // Загружаем фото по ссылке с ограничением на 3 секунды
                $response = Http::timeout($this->maxSingleDownloadTime)->get($imagePath);

                // Засекаем время, затраченное на загрузку
                $timeSpent = microtime(true) - $singleStartTime;

                if ($response->successful()) {
                    // Получаем содержимое файла
                    $fileContent = $response->body();

                    // Генерируем уникальное имя файла для локальной версии
                    $fileName = Str::random(10) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

                    // Сохраняем файл на сервере (например, в директории 'public/st_news_photos')
                    $filePath = $this->dir_for_photo . "/{$fileName}";
                    Storage::disk('public')->put($filePath, $fileContent);

                    // Обновляем ту же запись, добавляя ссылку на локальную фотографию
                    $photo->update([
                        'local_photo' => "/storage/{$filePath}", // Ссылка на новое местоположение локального фото
                    ]);

                    // Логируем успех загрузки
                    $fileSize = strlen($fileContent);
                    $return['loaded'][$imagePath] = $fileName;
                    $return['log'][] = "Успешно загружено фото: {$imagePath}. Локальный файл: {$fileName}. Размер: {$fileSize} байт. Время загрузки: {$timeSpent} секунд.";
                } else {
                    // Логируем неудачную попытку загрузки
                    $return['log'][] = "Не удалось загрузить фото: {$imagePath}. Код ответа: {$response->status()}.";


                    try {
                        // Засекаем время начала загрузки конкретного фото
                        $singleStartTime = microtime(true);

                        // Загружаем фото по ссылке с помощью cURL
                        $ch = curl_init($imagePath);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, $this->maxSingleDownloadTime); // 3 секунды

                        $fileContent = curl_exec($ch);

                        if ($fileContent === false) {
                            // Логируем ошибку
                            $return['log'][] = "Ошибка при загрузке фото через cURL: {$imagePath}. Ошибка: " . curl_error($ch);
                        } else {
                            // Генерируем уникальное имя файла для локальной версии
                            $fileName = Str::random(10) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

                            // Сохраняем файл на сервере
                            $filePath = $this->dir_for_photo . "/{$fileName}";
                            Storage::disk('public')->put($filePath, $fileContent);

                            // Обновляем запись с локальной фотографией
                            $photo->update([
                                'local_photo' => "storage/{$filePath}",
                            ]);

                            // Логируем успех загрузки
                            $fileSize = strlen($fileContent)/1024;
                            $return['loaded_size'] += $fileSize;
                            $return['loaded'][$imagePath] = $fileName;
                            $return['log'][] = "Успешно загружено фото: {$imagePath}. Локальный файл: {$fileName}. Размер: {$fileSize} кбайт. Время загрузки: " . (microtime(true) - $singleStartTime) . " секунд.";
                        }

                        curl_close($ch);
                    } catch (\Exception $e) {
                        // Логируем ошибку при загрузке
                        $return['log'][] = "Ошибка загрузки фото: {$imagePath}. Ошибка: {$e->getMessage()}.";
                    }



                }
            } catch (\Exception $e) {
                // Логируем ошибку при загрузке
                $return['log'][] = "Ошибка загрузки фото: {$imagePath}. Ошибка: {$e->getMessage()}.";
            }
        }

        return $return;
    }
}
