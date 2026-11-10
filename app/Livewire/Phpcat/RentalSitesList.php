<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatRentalSite;
use App\Services\VkNotifierService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RentalSitesList extends Component
{
    #[Locked]
    public ?int $siteId = null;

    public string $phone = '';

    public string $message = '';

    public string $website = '';

    #[Locked]
    public bool $sent = false;

    public function openRental(int $id): void
    {
        $site = PhpcatRentalSite::query()->where('is_visible', true)->where('is_rented', false)->findOrFail($id);
        $this->reset(['phone', 'message', 'website', 'sent']);
        $this->resetValidation();
        $this->siteId = $site->id;
        $this->dispatch('rental-open');
    }

    public function submit(VkNotifierService $notifier): void
    {
        if ($this->sent) {
            return;
        }

        $this->validate([
            'phone' => ['required', 'string', 'max:25', 'regex:/^[+0-9()\\s-]+$/', function ($attribute, $value, $fail) {
                $digits = preg_replace('/\\D/', '', $value);
                if (strlen($digits) < 10 || strlen($digits) > 15) {
                    $fail('Укажите корректный номер телефона.');
                }
            }],
            'message' => ['required', 'string', 'max:2000'],
            'website' => ['nullable', 'max:0'],
        ], [
            'phone.required' => 'Укажите номер телефона.',
            'phone.max' => 'Номер телефона слишком длинный.',
            'phone.regex' => 'Укажите корректный номер телефона.',
            'message.required' => 'Напишите сообщение.',
            'message.max' => 'Сообщение должно быть не длиннее 2000 символов.',
        ]);

        $site = PhpcatRentalSite::query()->where('is_visible', true)->where('is_rented', false)->find($this->siteId);
        if (! $site) {
            $this->addError('form', 'Этот сайт больше недоступен для аренды.');

            return;
        }

        $key = 'phpcat-rental:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('form', 'Слишком много заявок. Попробуйте через минуту.');

            return;
        }
        RateLimiter::hit($key, 60);

        try {
            $notifier->send("Заявка на аренду сайта с PHP Cat\nСайт: {$site->url()}\nТелефон: {$this->phone}\nСообщение: {$this->message}");
        } catch (\Throwable $exception) {
            $this->addError('form', 'Не удалось отправить заявку. Пожалуйста, попробуйте ещё раз.');

            return;
        }

        $this->reset(['phone', 'message', 'website']);
        $this->resetValidation();
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.phpcat.rental-sites-list', [
            'selectedSite' => $this->siteId ? PhpcatRentalSite::find($this->siteId) : null,
            'sites' => PhpcatRentalSite::query()
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
