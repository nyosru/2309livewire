<?php

namespace App\Livewire\Phpcat\Admin;

use App\Models\PhpcatServices;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ServicesAdmin extends Component
{
    private const SESSION_KEY = 'phpcat_services_admin_authorized';

    public string $password = '';

    public ?int $editId = null;

    public string $title = '';

    public string $link = '';

    public string $linkTitle = '';

    public string $imgUrl = '';

    public string $opis = '';

    public string $onoff = 'on';

    public function login(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ], [], [
            'password' => 'пароль',
        ]);

        $this->refreshSecretConfig();

        $expectedPassword = (string) config('custom.sercret', '');

        if ($expectedPassword === '') {
            $this->addError('password', 'Переменная sercret не задана в .env.');

            return;
        }

        $rateLimitKey = 'phpcat-services-admin:'.request()->ip();

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
            'title' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:2048'],
            'linkTitle' => ['nullable', 'string', 'max:255'],
            'imgUrl' => ['nullable', 'string', 'max:2048'],
            'opis' => ['required', 'string'],
            'onoff' => ['required', Rule::in(['on', 'off'])],
        ], [], [
            'title' => 'название',
            'link' => 'ссылка',
            'linkTitle' => 'подпись ссылки',
            'imgUrl' => 'URL изображения',
            'opis' => 'описание',
            'onoff' => 'видимость',
        ]);

        $service = $this->editId
            ? PhpcatServices::query()->findOrFail($this->editId)
            : new PhpcatServices;

        $service->fill([
            'title' => $validated['title'],
            'link' => $validated['link'] ?: null,
            'link_title' => $validated['linkTitle'] ?: null,
            'img_url' => $validated['imgUrl'] ?: null,
            'opis' => $validated['opis'],
            'onoff' => $validated['onoff'],
        ])->save();

        $message = $this->editId ? 'Сервис обновлён.' : 'Сервис добавлен.';

        $this->resetForm();
        session()->flash('success', $message);
    }

    public function edit(int $id): void
    {
        $this->ensureAuthorized();

        $service = PhpcatServices::query()->findOrFail($id);

        $this->editId = $service->id;
        $this->title = $service->title;
        $this->link = $service->link ?? '';
        $this->linkTitle = $service->link_title ?? '';
        $this->imgUrl = $service->img_url ?? '';
        $this->opis = $service->opis;
        $this->onoff = $service->onoff;
        $this->resetErrorBag();
    }

    public function delete(int $id): void
    {
        $this->ensureAuthorized();

        PhpcatServices::query()->findOrFail($id)->delete();

        if ($this->editId === $id) {
            $this->resetForm();
        }

        session()->flash('success', 'Сервис удалён.');
    }

    public function toggleVisibility(int $id): void
    {
        $this->ensureAuthorized();

        $service = PhpcatServices::query()->findOrFail($id);
        $service->update([
            'onoff' => $service->onoff === 'on' ? 'off' : 'on',
        ]);

        if ($this->editId === $service->id) {
            $this->onoff = $service->onoff;
        }

        session()->flash(
            'success',
            $service->onoff === 'on' ? 'Сервис опубликован.' : 'Сервис скрыт.',
        );
    }

    public function cancelEdit(): void
    {
        $this->ensureAuthorized();
        $this->resetForm();
    }

    public function render()
    {
        $authorized = $this->isAuthorized();

        return view('livewire.phpcat.admin.services-admin', [
            'authorized' => $authorized,
            'services' => $authorized
                ? PhpcatServices::query()->latest()->get()
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
        $this->reset([
            'editId',
            'title',
            'link',
            'linkTitle',
            'imgUrl',
            'opis',
        ]);
        $this->onoff = 'on';
        $this->resetErrorBag();
    }
}
