<?php

namespace App\Livewire\Vk;

use App\Models\VkManagerAccount;
use App\Models\VkManagerContactData;
use App\Models\VkManagerEducationData;
use App\Models\VkManagerMembership;
use App\Models\VkManagerPerson;
use App\Models\VkManagerProfileData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountHistory extends Component
{
    public string $searchTerm = '';

    public ?int $selectedPersonId = null;

    public bool $showHistory = false;

    public ?string $searchError = null;

    public function mount(): void
    {
        abort_unless(Auth::check(), 403);
    }

    public function updatedSearchTerm(): void
    {
        $this->selectedPersonId = null;
        $this->showHistory = false;
        $this->searchError = null;
    }

    public function selectPerson(int $personId): void
    {
        $person = $this->personQuery()->whereKey($personId)->first();
        if (! $person) {
            $this->selectedPersonId = null;
            $this->searchError = 'Этот профиль не найден в истории вашего аккаунта.';

            return;
        }

        $this->selectedPersonId = (int) $person->getKey();
        $this->searchTerm = $person->display_name.' · VK ID '.$person->vk_id;
        $this->showHistory = false;
        $this->searchError = null;
    }

    public function showSelected(): void
    {
        $person = $this->selectedPersonId
            ? $this->personQuery()->whereKey($this->selectedPersonId)->first()
            : $this->findExactSearchMatch();

        if (! $person) {
            $this->selectedPersonId = null;
            $this->showHistory = false;
            $this->searchError = 'Выберите контакт из подсказок или введите точный VK ID.';

            return;
        }

        $this->selectedPersonId = (int) $person->getKey();
        $this->showHistory = true;
        $this->searchError = null;
    }

    private function findExactSearchMatch(): ?VkManagerPerson
    {
        $term = trim($this->searchTerm);
        if ($term === '') {
            return null;
        }

        $vkId = preg_replace('/^VK ID\s*/iu', '', $term);
        if (preg_match('/^[1-9][0-9]{0,19}$/', $vkId)) {
            return $this->personQuery()->where('vk_id', $vkId)->first();
        }

        return $this->personQuery()->where('display_name', $term)->first();
    }

    private function personQuery(): Builder
    {
        $accountId = VkManagerAccount::query()
            ->where('user_id', Auth::id())
            ->value('id');

        return VkManagerPerson::query()
            ->whereHas('memberships', fn (Builder $query) => $query->where('account_id', $accountId));
    }

    private function searchResults(): array
    {
        $term = trim($this->searchTerm);
        if ($term === '' || $this->selectedPersonId !== null) {
            return [];
        }

        $term = mb_substr($term, 0, 100);
        $escaped = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $term);

        return $this->personQuery()
            ->where(function (Builder $query) use ($escaped): void {
                $query->where('vk_id', 'like', $escaped.'%')
                    ->orWhere('display_name', 'like', '%'.$escaped.'%')
                    ->orWhere('first_name', 'like', '%'.$escaped.'%')
                    ->orWhere('last_name', 'like', '%'.$escaped.'%');
            })
            ->orderBy('display_name')
            ->limit(25)
            ->get(['id', 'vk_id', 'display_name', 'photo_url'])
            ->map(fn (VkManagerPerson $person): array => [
                'id' => (int) $person->getKey(),
                'vk_id' => (string) $person->vk_id,
                'name' => $person->display_name ?: 'Пользователь VK',
                'photo_url' => $person->photo_url,
            ])
            ->all();
    }

    private function historyData(): ?array
    {
        if (! $this->showHistory || ! $this->selectedPersonId) {
            return null;
        }

        $person = $this->personQuery()->whereKey($this->selectedPersonId)->first();
        if (! $person) {
            $this->selectedPersonId = null;
            $this->showHistory = false;

            return null;
        }

        $accountId = VkManagerAccount::query()->where('user_id', Auth::id())->value('id');
        $categories = [
            ['model' => VkManagerProfileData::class, 'key' => 'profile', 'label' => 'Профиль, фото и основные сведения'],
            ['model' => VkManagerEducationData::class, 'key' => 'education', 'label' => 'Учёба, работа и служба'],
            ['model' => VkManagerContactData::class, 'key' => 'contacts', 'label' => 'Контакты и ссылки'],
        ];
        $currentData = [];
        $events = [];
        $sequence = 0;

        foreach ($categories as $category) {
            $records = $category['model']::query()
                ->where('account_id', $accountId)
                ->where('person_id', $person->getKey())
                ->orderBy('created_at')
                ->orderBy('id')
                ->get();

            $current = $records->whereNull('obsolete_at')->last();
            if ($current) {
                $currentData[] = [
                    'key' => $category['key'],
                    'label' => $category['label'],
                    'data' => $current->data ?? [],
                ];
            }

            foreach ($records as $record) {
                $events[] = [
                    'at' => $record->created_at,
                    'sequence' => $sequence++,
                    'kind' => 'data',
                    'title' => 'Сохранены данные: '.$category['label'],
                    'source' => $record->source,
                    'data' => $record->data ?? [],
                    'obsolete_at' => $record->obsolete_at,
                ];
            }
        }

        $memberships = VkManagerMembership::query()
            ->where('account_id', $accountId)
            ->where('person_id', $person->getKey())
            ->orderBy('started_at')
            ->orderBy('id')
            ->get();
        $membershipCount = $memberships->count();

        foreach ($memberships as $index => $membership) {
            $previous = $index > 0 ? $memberships[$index - 1] : null;
            $next = $index + 1 < $membershipCount ? $memberships[$index + 1] : null;
            $events[] = [
                'at' => $membership->started_at,
                'sequence' => $sequence++,
                'kind' => 'status',
                'title' => $this->statusTitle($membership->status, $previous?->status),
                'source' => $membership->source,
                'status' => $membership->status,
                'previous_status' => $previous?->status,
                'ended_at' => $membership->ended_at,
                'transitioned' => $next !== null,
            ];

            $hasGapBeforeNext = $membership->ended_at
                && $next
                && $membership->ended_at->lt($next->started_at);
            if ($membership->ended_at && (! $next || $hasGapBeforeNext)) {
                $events[] = [
                    'at' => $membership->ended_at,
                    'sequence' => $sequence++,
                    'kind' => 'closed',
                    'title' => $this->closedStatusTitle($membership->status),
                    'source' => $membership->source,
                ];
            }
        }

        usort($events, function (array $left, array $right): int {
            $byDate = $right['at']->getTimestamp() <=> $left['at']->getTimestamp();

            return $byDate !== 0 ? $byDate : $right['sequence'] <=> $left['sequence'];
        });

        return [
            'person' => $person,
            'current_data' => $currentData,
            'events' => $events,
        ];
    }

    private function statusTitle(string $status, ?string $previousStatus): string
    {
        if ($previousStatus === VkManagerMembership::STATUS_OUTGOING_REQUEST && $status === VkManagerMembership::STATUS_FRIEND) {
            return 'Заявка принята — контакт стал другом';
        }
        if ($previousStatus === VkManagerMembership::STATUS_FRIEND && $status === VkManagerMembership::STATUS_FOLLOWER) {
            return 'Удалён из друзей, остался подписчиком';
        }
        if ($previousStatus === VkManagerMembership::STATUS_FOLLOWER && $status === VkManagerMembership::STATUS_FRIEND) {
            return 'Подписчик стал другом';
        }

        return match ($status) {
            VkManagerMembership::STATUS_FRIEND => 'Зафиксирован статус «Друг»',
            VkManagerMembership::STATUS_FOLLOWER => 'Зафиксирован статус «Подписчик»',
            VkManagerMembership::STATUS_OUTGOING_REQUEST => 'Отправлена заявка в друзья',
            default => 'Изменился статус контакта',
        };
    }

    private function closedStatusTitle(string $status): string
    {
        return match ($status) {
            VkManagerMembership::STATUS_FRIEND => 'Контакт перестал быть другом',
            VkManagerMembership::STATUS_FOLLOWER => 'Контакт перестал быть подписчиком',
            VkManagerMembership::STATUS_OUTGOING_REQUEST => 'Заявка больше не отображается в исходящих',
            default => 'Период статуса завершён',
        };
    }

    public function render()
    {
        return view('livewire.vk.account-history', [
            'suggestions' => $this->searchResults(),
            'history' => $this->historyData(),
        ]);
    }
}
