<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhoisDomain extends Model
{
    use HasFactory;

    /**
     * Подключение, которое должно использоваться моделью.
     *
     * @var string
     */
    protected $connection = 'sqlite_domains'; // Замените 'mysql' на имя вашего подключения

}
