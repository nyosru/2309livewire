<?php

use App\Http\Controllers\RaalProjectController;
use App\Models\RaalProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

$raalRoutes = function () {
    Route::get('/', function () {
        return view('raal.index', [
            'projects' => RaalProject::active()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    })->name('index');

    Route::post('/consultation', function (Request $request) {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:40'],
            'city' => ['required', 'string', 'max:120'],
            'preferred_time' => ['required', 'string', 'max:1000'],
            'project' => ['nullable', 'string', 'max:120'],
            'website' => ['nullable', 'max:0'],
        ]);

        Log::channel('daily')->info('Новая заявка с сайта РААЛ', [
            'phone' => $data['phone'],
            'city' => $data['city'],
            'preferred_time' => $data['preferred_time'],
            'project' => $data['project'] ?? null,
            'source' => 'raal',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Заявка принята. Мы свяжемся с вами, чтобы подтвердить время.']);
        }

        return back()->with('consultation_sent', true);
    })->middleware('throttle:10,1')->name('consultation');

    Route::get('/adm_/login', function (Request $request) {
        if ($request->session()->get('raal_admin_authenticated') === true) {
            return redirect()->route('raal.admin.projects.index');
        }

        return view('raal.admin.login');
    })->name('admin.login');

    Route::post('/adm_/login', function (Request $request) {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $configuredPassword = (string) config('services.raal.admin_password');

        if ($configuredPassword === '') {
            return back()->withErrors(['password' => 'Пароль администратора не настроен.'])->onlyInput();
        }

        if (! hash_equals($configuredPassword, (string) $request->input('password'))) {
            return back()->withErrors(['password' => 'Неверный пароль.'])->onlyInput();
        }

        $request->session()->regenerate();
        $request->session()->put('raal_admin_authenticated', true);

        return redirect()->intended(route('raal.admin.projects.index'));
    })->middleware('throttle:1,1')->name('admin.login.submit');

    Route::middleware('raal.admin')->prefix('adm_')->as('admin.')->group(function () {
        Route::get('/', fn () => redirect()->route('raal.admin.projects.index'))->name('index');
        Route::resource('projects', RaalProjectController::class)->except('show');
        Route::post('/logout', function (Request $request) {
            $request->session()->forget('raal_admin_authenticated');
            $request->session()->regenerateToken();

            return redirect()->route('raal.admin.login');
        })->name('logout');
    });
};

Route::group([
    'as' => 'raal.',
    'domain' => app()->environment('local') ? 'raal.local' : 'xn--80aa7ar.xn--p1ai',
], $raalRoutes);
