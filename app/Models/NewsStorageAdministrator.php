<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class NewsStorageAdministrator extends Model
{
    use HasFactory;

    public const ROLE_ADMINISTRATOR = 'administrator';

    public const ROLE_MODERATOR = 'moderator';

    protected $fillable = ['user_id', 'vk_id', 'role', 'last_login_at'];

    protected $casts = ['last_login_at' => 'datetime'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function registerLogin(User $user): self
    {
        return DB::transaction(function () use ($user) {
            $access = self::query()->where('user_id', $user->id)->lockForUpdate()->first();

            if (! $access) {
                $access = self::create([
                    'user_id' => $user->id,
                    'vk_id' => $user->vk_id,
                ]);
            }

            $hasAdministrators = self::query()
                ->where('role', self::ROLE_ADMINISTRATOR)
                ->lockForUpdate()
                ->exists();

            if (! $hasAdministrators) {
                $access->role = self::ROLE_ADMINISTRATOR;
            }

            $access->fill([
                'vk_id' => $user->vk_id,
                'last_login_at' => now(),
            ])->save();

            return $access;
        });
    }

    public function canManage(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    public function canModerate(): bool
    {
        return in_array($this->role, [self::ROLE_ADMINISTRATOR, self::ROLE_MODERATOR], true);
    }
}
