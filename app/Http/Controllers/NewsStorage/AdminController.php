<?php

namespace App\Http\Controllers\NewsStorage;

use App\Http\Controllers\Controller;
use App\Models\NewsStorageAdministrator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $access = NewsStorageAdministrator::query()->where('user_id', auth()->id())->firstOrFail();

        return view('news_storage.admin.index', [
            'access' => $access,
            'requests' => $access->canManage()
                ? NewsStorageAdministrator::query()->with('user')->latest('last_login_at')->get()
                : collect(),
        ]);
    }

    public function updateAccess(Request $request, NewsStorageAdministrator $administrator): RedirectResponse
    {
        Gate::authorize('manage-news-storage');

        $data = $request->validate([
            'role' => ['nullable', Rule::in([
                NewsStorageAdministrator::ROLE_ADMINISTRATOR,
                NewsStorageAdministrator::ROLE_MODERATOR,
            ])],
        ]);

        if ($administrator->role === NewsStorageAdministrator::ROLE_ADMINISTRATOR
            && ($data['role'] ?? null) !== NewsStorageAdministrator::ROLE_ADMINISTRATOR
            && NewsStorageAdministrator::query()->where('role', NewsStorageAdministrator::ROLE_ADMINISTRATOR)->count() === 1) {
            return back()->withErrors(['role' => 'Нельзя снять права у единственного администратора.']);
        }

        $administrator->update(['role' => $data['role'] ?? null]);

        return back()->with('status', 'Права доступа обновлены.');
    }
}
