<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Livewire\Auth\Vk;
use App\Models\Vkusno\Administrator;
use App\Services\Max\MaxAuthService;
use App\Services\Max\MaxService;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(MaxAuthService $max, MaxService $bot)
    {
        if (Auth::check() && Administrator::canManage(Auth::user())) {
            return redirect('/admin');
        }

        $maxBotUrl = $bot->botUrl();
        $maxBotQr = $maxBotUrl ? (new SvgWriter)->write(new QrCode(data: $maxBotUrl, size: 180, margin: 24))->getDataUri() : null;

        return view('vkusno.admin.login', ['maxReady' => $max->configured(), 'maxBotUrl' => $maxBotUrl, 'maxBotQr' => $maxBotQr]);
    }

    public function redirect(Request $request)
    {
        $this->configureCallback();
        $request->session()->put('url.intended', '/admin');
        $request->session()->put('vk_auth_error_redirect', '/admin/login');

        return app(Vk::class)->redir();
    }

    public function callback()
    {
        $this->configureCallback();
        session()->put('vk_auth_error_redirect', '/admin/login');

        return app(Vk::class)->handleVKCallback();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    private function configureCallback(): void
    {
        config(['services.vk.redirect' => url('/admin/auth/vk/callback')]);
    }
}
