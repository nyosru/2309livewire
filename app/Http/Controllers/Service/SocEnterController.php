<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocEnterController extends Controller
{
    static public function enter($user)
    {


        $data = [];
        $data['email'] = $user->getEmail();
        $data['name'] = $user->getName();
        $data['avatar'] = $user->getAvatar();
        $data['nick'] = $user->getNickname();
        $data['socIdVk'] = $user->getId();

        if (empty($data['email'])) {
            $data['email'] = $data['socIdVk'] . '@vk.com';
        }

        $data['password'] = Hash::make(rand(0,99999));
        $userNow = User::firstOrCreate(
            ['email' => $data['email']],
            $data
        );
        // dd( __LINE__, $e);
        return $userNow;
    }
}
