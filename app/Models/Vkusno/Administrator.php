<?php

namespace App\Models\Vkusno;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'vkusno_administrators';

    protected $fillable = ['vk_id', 'name', 'granted_by_vk_id', 'granted_by_user_id'];

    public static function isSuperAdmin(User $user): bool
    {
        $superAdminId = (string) config('vkusno.super_admin_vk_id');

        if ($superAdminId !== '' && (string) $user->vk_id === $superAdminId) {
            return true;
        }
        $superPhone = (string) config('vkusno.super_admin_phone');

        return preg_match('/^\+79[0-9]{9}$/D', $superPhone) && $user->getKey()
            && PhoneAdministrator::where('phone', $superPhone)->where('user_id', $user->getKey())->exists();
    }

    public static function canManage(User $user): bool
    {
        return static::isSuperAdmin($user)
            || ($user->vk_id && static::where('vk_id', $user->vk_id)->exists())
            || ($user->getKey() && PhoneAdministrator::where('user_id', $user->getKey())->exists());
    }
}
