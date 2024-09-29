<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{

    /**
     * Получить полный размер директории в байтах.
     *
     * @param string $directory
     * @return int
     */
    static function getFolderSizeFull($directory)
    {
        if (!is_dir($directory)) {
            $status = 'error';
            $msg = 'no dir';
        } else {
            $sizeInBytes = self::getFolderSizeUsingDu($directory);

            if (!empty($sizeInBytes)) {
                $sizeInMB = (int)$sizeInBytes;
                $status = 'ok';
                $msg = 'function getFolderSizeUsingDu';
            } else {
                $sizeInBytes = self::getFolderSize($directory);

                if (!empty($sizeInBytes)) {
                    // Преобразуем размер в мегабайты для удобства
                    $sizeInMB = round($sizeInBytes / (1024 * 1024), 1);
                    $status = 'ok';
                    $msg = 'function getFolderSize';
                } else {
                    $status = 'error';
                }
            }
        }

        return ['mb' => $sizeInMB ?? 0, 'status' => $status, 'msg' => $msg ?? ''];
    }

    /**
     * Получить полный размер директории в байтах.
     *
     * @param string $directory
     * @return int
     */
    static function getFolderSize($directory)
    {
        $size = 0;

        // Рекурсивно перебираем все файлы и папки в директории
        foreach (File::allFiles($directory) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }


    /**
     * Получить размер директории с помощью команды du -sh
     *
     * @param string $directory
     * @return string|null
     */
    static function getFolderSizeUsingDu($directory)
    {
        // Проверяем, существует ли директория
        if (is_dir($directory)) {
            // Выполняем команду du -sh
            $output = shell_exec("du -sh " . escapeshellarg($directory));

            // Если результат не пустой, возвращаем строку с размером
            if (!empty($output)) {
                // Разделяем вывод по табуляции и возвращаем только размер
                return explode("\t", $output)[0];
            }
        }

        // Возвращаем null, если что-то пошло не так
        return null;
    }
}
