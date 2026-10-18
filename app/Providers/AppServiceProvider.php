<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('manage-ttt-clubs', function (User $user): bool {
            if (in_array($user->email, ['1@php-cat.com', 'nyos@rambler.ru'], true)) {
                return true;
            }

            return $user->getAllPermissions()->contains(
                fn ($permission) => in_array($permission->name, ['Полный//доступ', 'ттт.Клубы'], true),
            );
        });

        \Illuminate\Support\Facades\Http::globalOptions([
            'verify' => false, // для полного отключения
        ]);

        // проверка разрешений
        Blade::if('permission', function ($permission) {
            $user = Auth::user();

            // Проверяем email пользователя
            if ($user && (
                $user->email === '1@php-cat.com'
                || $user->email === 'nyos@rambler.ru'
            )) {
                return true;
            } // полный доступ
            elseif ($user && $user->can('Полный//доступ')) {
                return true;
            }

            return $user && $user->can($permission);
        });

        // Проверка любого из разрешений
        Blade::if('anyPermission', function (...$permissions) {
            $user = Auth::user();

            // Email bypass
            if ($user && $user->email === '1@php-cat.com') {
                return true;
            } // полный доступ
            elseif ($user && $user->can('Полный//доступ')) {
                return true;
            }

            foreach ($permissions as $permission) {
                if ($user && $user->can($permission)) {
                    return true;
                }
            }

            return false;
        });
    }
}
