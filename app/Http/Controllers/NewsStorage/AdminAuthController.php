<?php

namespace App\Http\Controllers\NewsStorage;

use App\Http\Controllers\Controller;
use App\Livewire\Auth\Vk;
use App\Models\NewsStorageAdministrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        $access = Auth::check()
            ? NewsStorageAdministrator::query()->where('user_id', Auth::id())->first()
            : null;

        if ($access?->canModerate()) {
            return redirect('/admin');
        }

        return view('news_storage.admin.login', [
            'access' => $access,
        ]);
    }

    public function redirect(Request $request): RedirectResponse
    {
        $this->configureCallback();
        $request->session()->put('url.intended', '/admin');
        $request->session()->put('vk_auth_error_redirect', '/admin/login');
        $request->session()->put('news_storage_admin_login', true);

        return app(Vk::class)->redir();
    }

    public function callback(Request $request): RedirectResponse
    {
        // Старый адрес сохраняем, но обрабатывает вход единый callback /auth/vk/callback.
        return redirect('/auth/vk/callback'.($request->getQueryString() ? '?'.$request->getQueryString() : ''));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    private function configureCallback(): void
    {
        config(['services.vk.redirect' => url('/auth/vk/callback')]);
    }
}
