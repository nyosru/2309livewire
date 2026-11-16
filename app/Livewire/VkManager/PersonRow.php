<?php

namespace App\Livewire\VkManager;

use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerMembership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PersonRow extends Component
{
    /** @var array<string, mixed> */
    #[Reactive]
    public array $person = [];

    public string $activeTab = 'friends';

    #[Reactive]
    public bool $selected = false;

    public bool $favorite = false;

    public string $commentDraft = '';

    public bool $commentSaved = false;

    /**
     * @param  array<string, mixed>  $person
     */
    public function mount(array $person = [], string $activeTab = 'friends', bool $selected = false): void
    {
        $this->person = $person;
        $this->activeTab = $activeTab;
        $this->selected = $selected;
        $this->favorite = (bool) ($person['manager_favorite'] ?? false);
        $this->commentDraft = (string) ($person['manager_comment'] ?? '');
    }

    public function updatedCommentDraft(): void
    {
        $this->commentSaved = false;
    }

    public function toggleSelection(bool $checked): void
    {
        $this->dispatch('vk-row-selected', id: $this->vkId(), checked: $checked);
    }

    public function toggleFavorite(): void
    {
        $vkId = $this->vkId();
        $this->assertCurrentContact($vkId);

        $contact = VkManagerContact::query()->firstOrNew([
            'user_id' => Auth::id(),
            'vk_friend_id' => $vkId,
        ]);
        $contact->is_favorite = ! (bool) $contact->is_favorite;
        $contact->save();

        $this->favorite = (bool) $contact->is_favorite;
        $this->dispatch(
            'vk-contact-updated',
            message: $this->favorite ? 'Контакт добавлен в избранное.' : 'Контакт убран из избранного.',
            isError: false,
        );
    }

    public function saveComment(): void
    {
        $vkId = $this->vkId();
        $this->assertCurrentContact($vkId);
        $this->validate([
            'commentDraft' => ['nullable', 'string', 'max:2000'],
        ]);

        $comment = trim($this->commentDraft);
        VkManagerContact::query()->updateOrCreate(
            ['user_id' => Auth::id(), 'vk_friend_id' => $vkId],
            ['comment' => $comment === '' ? null : $comment],
        );

        $this->commentDraft = $comment;
        $this->commentSaved = true;
        $this->dispatch('vk-contact-updated', message: 'Комментарий сохранён.', isError: false);
    }

    public function render(): View
    {
        return view('livewire.vk_manager.person-row');
    }

    private function vkId(): string
    {
        return (string) ($this->person['id'] ?? '');
    }

    private function assertCurrentContact(string $vkId): void
    {
        abort_unless(preg_match('/^[1-9][0-9]{0,19}$/', $vkId), 404);
        $accountId = VkManagerAccount::query()->where('user_id', Auth::id())->value('id');
        abort_unless(VkManagerMembership::query()
            ->where('account_id', $accountId)
            ->where('is_current', true)
            ->whereHas('person', fn (Builder $query) => $query->where('vk_id', $vkId))
            ->exists(), 404);
    }
}
