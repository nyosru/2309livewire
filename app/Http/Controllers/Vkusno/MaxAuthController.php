<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vkusno\PhoneAdministrator;
use App\Services\Max\MaxAuthException;
use App\Services\Max\MaxAuthService;
use App\Services\Max\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class MaxAuthController extends Controller
{
    private const PURPOSE = 'vkusno.admin';

    public function requestCode(Request $request, MaxAuthService $max)
    {
        $data = $request->validate(['phone' => ['required', 'string', 'max:32']]);
        $phone = PhoneNumber::normalize($data['phone']);
        $browser = $request->session()->get('max_auth_browser', Str::random(64));
        $request->session()->put('max_auth_browser', $browser);
        try {
            $allowed = $phone === (string) config('vkusno.super_admin_phone') || PhoneAdministrator::where('phone', $phone)->exists();
            $verification = $max->begin($phone, self::PURPOSE, $browser, $request->ip(), $allowed, 'Вкусняжки72');
        } catch (MaxAuthException|TooManyRequestsHttpException $exception) {
            return redirect('/admin/login')->withErrors(['phone' => $exception->getMessage()])->withInput($request->only('phone'));
        }
        $request->session()->put('vkusno_max_challenge', [
            'id' => $verification->id, 'code_length' => $verification->code_length,
            'masked_phone' => '+7 *** ***-'.substr($phone, -4, 2).'-'.substr($phone, -2),
            'phone' => $phone,
        ]);

        return redirect('/admin/login')->with('status', 'Если номеру разрешён доступ, код отправлен в MAX. Введите его ниже.');
    }

    public function verify(Request $request, MaxAuthService $max)
    {
        $data = $request->validate(['max_code' => ['required', 'string', 'regex:/^[0-9]{6}$/D']]);
        $challenge = $request->session()->get('vkusno_max_challenge');
        $browser = $request->session()->get('max_auth_browser');
        $phone = null;
        if (is_array($challenge) && is_string($browser)) {
            try {
                $phone = $max->confirm($challenge['id'], self::PURPOSE, $browser, $data['max_code']);
            } catch (MaxAuthException $exception) {
                throw ValidationException::withMessages(['code' => $exception->getMessage()]);
            }
        }
        if (! $phone) {
            throw ValidationException::withMessages(['code' => 'Код неверен, истёк или уже использован. Запросите новый код.']);
        }
        $user = DB::transaction(function () use ($phone) {
            $administrator = PhoneAdministrator::where('phone', $phone)->lockForUpdate()->first();
            if (! $administrator && $phone === (string) config('vkusno.super_admin_phone')) {
                $administrator = PhoneAdministrator::create(['phone' => $phone, 'name' => 'Суперадминистратор MAX']);
            }
            if (! $administrator) {
                return null;
            }
            $user = $administrator->user;
            if (! $user) {
                // Never merge by a submitted phone/email with an existing privileged account.
                $user = User::create([
                    'name' => $administrator->name ?: 'Администратор MAX',
                    'email' => 'max-'.Str::uuid().'@vkusno.invalid',
                    'password' => Str::random(64),
                ]);
                $administrator->user_id = $user->id;
                $administrator->save();
            }

            return $user;
        });
        if (! $user) {
            throw ValidationException::withMessages(['code' => 'Доступ к панели не разрешён или был отозван.']);
        }
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->forget(['vkusno_max_challenge', 'max_auth_browser', 'url.intended']);

        return redirect('/admin');
    }

    public function reset(Request $request)
    {
        $request->session()->forget(['vkusno_max_challenge', 'max_auth_browser']);

        return redirect('/admin/login');
    }
}
