<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\Max\Verification;
use App\Models\Vkusno\Administrator;
use App\Models\Vkusno\PhoneAdministrator;
use App\Services\Max\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccessAdminController extends Controller
{
    public function index()
    {
        return view('vkusno.admin.access', [
            'administrators' => Administrator::latest()->get(),
            'phoneAdministrators' => PhoneAdministrator::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vk_id' => ['required', 'string', 'regex:/^[1-9][0-9]{0,19}$/', Rule::notIn([(string) config('vkusno.super_admin_vk_id')]), Rule::unique('vkusno_administrators', 'vk_id')],
            'name' => ['nullable', 'string', 'max:100'],
        ]);
        Administrator::create($data + ['granted_by_vk_id' => (string) $request->user()->vk_id, 'granted_by_user_id' => $request->user()->id]);

        return redirect('/admin/access')->with('status', 'Доступ выдан. Пользователь может войти через свой VK-аккаунт.');
    }

    public function destroy(Administrator $administrator)
    {
        $administrator->delete();

        return redirect('/admin/access')->with('status', 'Доступ отозван.');
    }

    public function storePhone(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'name' => ['nullable', 'string', 'max:100'],
        ]);
        $phone = PhoneNumber::normalize($data['phone']);
        if (PhoneAdministrator::where('phone', $phone)->exists()) {
            throw ValidationException::withMessages(['phone' => 'Этому телефону уже выдан доступ.']);
        }
        PhoneAdministrator::create(['phone' => $phone, 'name' => $data['name'] ?? null, 'granted_by_user_id' => $request->user()->id]);

        return redirect('/admin/access')->with('status', 'Доступ через MAX выдан. ВКонтакте этому пользователю не нужен.');
    }

    public function destroyPhone(PhoneAdministrator $phoneAdministrator)
    {
        if ($phoneAdministrator->phone === (string) config('vkusno.super_admin_phone')) {
            throw ValidationException::withMessages(['phone' => 'Телефон суперадминистратора изменяется в настройках сервера.']);
        }
        DB::transaction(function () use ($phoneAdministrator) {
            Verification::where('phone', $phoneAdministrator->phone)->where('purpose', 'vkusno.admin')->where('status', 'pending')->update(['status' => 'revoked']);
            $phoneAdministrator->delete();
        });

        return redirect('/admin/access')->with('status', 'Доступ через MAX отозван.');
    }
}
