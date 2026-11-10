<?php

namespace App\Services;

use App\Models\User;

class VkAuthService
{
    public function findOrCreateUser(int $vkId, string $accessToken, ?string $email = null, ?string $name = null): User
    {
        $user = User::query()->where('vk_id', $vkId)->first();

        if (! $user && $email && $email !== $vkId.'@vk.com') {
            $user = User::query()->where('email', $email)->first();
        }

        if (! $user) {
            return User::create([
                'name' => $name ?? 'VK User '.$vkId,
                'email' => $email ?? ($vkId.'@vk.com'),
                'password' => bcrypt(uniqid()),
                'vk_id' => $vkId,
                'vk_token' => $accessToken,
            ]);
        }

        $user->update([
            'vk_id' => $vkId,
            'vk_token' => $accessToken,
        ]);

        return $user;
    }
}
