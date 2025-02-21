<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhpcatAiToken extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['name', 'value', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public static function storeToken(string $name, string $token, int $hours = 23): object
    {
        return self::updateOrCreate(
            ['name' => $name],
            ['value' => $token, 'expires_at' => now()->addHours($hours)]
        );
    }

    public static function getToken(string $name): ?string
    {
        $token = self::where('name', $name)
            ->where('expires_at', '>', now())
            ->first();

        return $token ? $token->value : null;
    }

}
