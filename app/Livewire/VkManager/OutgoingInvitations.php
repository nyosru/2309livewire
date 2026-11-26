<?php

namespace App\Livewire\VkManager;

use App\Services\VkManagerInvitationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class OutgoingInvitations extends Component
{
    public string $city = 'Тюмень';
    public string $sex = '';
    public string $ageFrom = '';
    public string $ageTo = '';
    public array $people = [];
    public array $statuses = [];
    public ?string $message = null;
    public bool $isError = false;

    public function mount(): void
    {
        abort_unless(Auth::check(), 403);
    }

    public function prepareList(VkManagerInvitationService $invitations): void
    {
        $this->validate([
            'city' => ['nullable', 'string', 'max:100'],
            'sex' => ['nullable', 'in:1,2'],
            'ageFrom' => ['nullable', 'integer', 'min:14', 'max:100'],
            'ageTo' => ['nullable', 'integer', 'min:14', 'max:100', 'gte:ageFrom'],
        ], [
            'ageTo.gte' => 'Максимальный возраст должен быть не меньше минимального.',
        ]);

        try {
            $this->people = $invitations->findCandidates(Auth::user(), [
                'city' => $this->city,
                'sex' => $this->sex,
                'age_from' => $this->ageFrom,
                'age_to' => $this->ageTo,
            ]);
            $this->statuses = [];
            $this->message = 'Подобрано аккаунтов: '.count($this->people).'.';
            $this->isError = false;
        } catch (Throwable $exception) {
            $this->people = [];
            $this->message = $exception->getMessage();
            $this->isError = true;
        }
    }

    public function sendInvitation(string $vkId, VkManagerInvitationService $invitations): void
    {
        if (! collect($this->people)->contains(fn ($person) => (string) ($person['id'] ?? '') === $vkId)) return;
        $this->statuses[$vkId] = 'Отправляю заявку…';

        try {
            $person = collect($this->people)->first(fn ($candidate) => (string) ($candidate['id'] ?? '') === $vkId) ?? [];
            $result = $invitations->invite(Auth::user(), $vkId, $person);
            $this->statuses[$vkId] = $result === 'friend' ? 'Пользователь уже добавлен в друзья' : 'Заявка отправлена';
            $this->message = $this->statuses[$vkId].' (VK ID '.$vkId.').';
            $this->isError = false;
        } catch (Throwable $exception) {
            $this->statuses[$vkId] = 'Ошибка: '.$exception->getMessage();
            $this->message = $exception->getMessage();
            $this->isError = true;
        }
    }

    public function render()
    {
        return view('livewire.vk_manager.outgoing-invitations');
    }
}
