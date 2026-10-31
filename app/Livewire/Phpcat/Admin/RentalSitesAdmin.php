<?php

namespace App\Livewire\Phpcat\Admin;

use App\Models\PhpcatRentalSite;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RentalSitesAdmin extends Component
{
    private const SESSION_KEY = 'phpcat_rental_sites_admin_authorized';

    public string $password = '';

    public ?int $editId = null;

    public string $domain = '';

    public string $category = '';

    public string $description = '';

    public bool $isRented = false;

    public bool $isVisible = true;

    public int $sortOrder = 0;

    public function login(): void
    {
        $this->validate(['password' => ['required', 'string']]);
        $this->refreshSecretConfig();

        $expectedPassword = (string) config('custom.sercret', '');
        if ($expectedPassword === '') {
            $this->addError('password', 'Переменная sercret не задана в .env.');

            return;
        }

        $rateLimitKey = 'phpcat-rental-sites-admin:'.request()->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $this->addError('password', 'Слишком много попыток. Повторите через минуту.');

            return;
        }

        if (! hash_equals($expectedPassword, $this->password)) {
            RateLimiter::hit($rateLimitKey, 60);
            $this->reset('password');
            $this->addError('password', 'Неверный пароль.');

            return;
        }

        RateLimiter::clear($rateLimitKey);
        session()->regenerate();
        session()->put(self::SESSION_KEY, true);
        $this->reset('password');
        $this->resetErrorBag();
    }

    public function logout(): void
    {
        session()->forget(self::SESSION_KEY);
        session()->regenerateToken();
        $this->resetForm();
    }

    public function save(): void
    {
        $this->ensureAuthorized();

        $validated = $this->validate([
            'domain' => [
                'required', 'string', 'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! preg_match('/^[\pL\pN](?:[\pL\pN.-]*[\pL\pN])?$/u', $value) || str_contains($value, '..')) {
                        $fail('Введите домен без http:// и https://.');
                    }
                },
                Rule::unique('phpcat_rental_sites', 'domain')->ignore($this->editId),
            ],
            'category' => ['nullable', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:2000'],
            'isRented' => ['boolean'],
            'isVisible' => ['boolean'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:100000'],
        ], [], [
            'domain' => 'домен',
            'category' => 'категория',
            'description' => 'описание',
            'sortOrder' => 'порядок',
        ]);

        $site = $this->editId
            ? PhpcatRentalSite::query()->findOrFail($this->editId)
            : new PhpcatRentalSite;

        $site->fill([
            'domain' => $validated['domain'],
            'category' => $validated['category'] ?: null,
            'description' => $validated['description'],
            'is_rented' => $validated['isRented'],
            'is_visible' => $validated['isVisible'],
            'sort_order' => $validated['sortOrder'],
        ])->save();

        $message = $this->editId ? 'Карточка обновлена.' : 'Карточка добавлена.';
        $this->resetForm();
        session()->flash('success', $message);
    }

    public function edit(int $id): void
    {
        $this->ensureAuthorized();
        $site = PhpcatRentalSite::query()->findOrFail($id);

        $this->editId = $site->id;
        $this->domain = $site->domain;
        $this->category = $site->category ?? '';
        $this->description = $site->description;
        $this->isRented = $site->is_rented;
        $this->isVisible = $site->is_visible;
        $this->sortOrder = $site->sort_order;
        $this->resetErrorBag();
    }

    public function delete(int $id): void
    {
        $this->ensureAuthorized();
        PhpcatRentalSite::query()->findOrFail($id)->delete();

        if ($this->editId === $id) {
            $this->resetForm();
        }

        session()->flash('success', 'Карточка удалена.');
    }

    public function cancelEdit(): void
    {
        $this->ensureAuthorized();
        $this->resetForm();
    }

    public function render()
    {
        $authorized = $this->isAuthorized();

        return view('livewire.phpcat.admin.rental-sites-admin', [
            'authorized' => $authorized,
            'sites' => $authorized
                ? PhpcatRentalSite::query()->orderBy('sort_order')->orderBy('id')->get()
                : collect(),
        ])->layout('livewire.phpcat.admin.layout');
    }

    private function ensureAuthorized(): void
    {
        abort_unless($this->isAuthorized(), 403);
    }

    private function isAuthorized(): bool
    {
        return session()->get(self::SESSION_KEY) === true;
    }

    private function refreshSecretConfig(): void
    {
        $environmentFile = app()->environmentFilePath();
        if (! is_readable($environmentFile)) {
            return;
        }

        try {
            $environment = Dotenv::parse((string) file_get_contents($environmentFile));
        } catch (\Throwable) {
            return;
        }

        if (array_key_exists('sercret', $environment)) {
            config()->set('custom.sercret', $environment['sercret']);
        }
    }

    private function resetForm(): void
    {
        $this->reset(['editId', 'domain', 'category', 'description']);
        $this->isRented = false;
        $this->isVisible = true;
        $this->sortOrder = 0;
        $this->resetErrorBag();
    }
}
