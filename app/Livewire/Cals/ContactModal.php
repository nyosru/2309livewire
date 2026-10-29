<?php

namespace App\Livewire\Cals;

use App\Models\Cals\Contact;
use Livewire\Attributes\On;
use Livewire\Component;

class ContactModal extends Component
{
    public bool $showModal = false;

    public ?int $contactId = null;

    public ?string $name = null;

    public ?string $phone = null;

    public ?string $companyName = null;

    public ?string $startDate = null;

    public ?string $notes = null;

    public string $commentBody = '';

    public array $comments = [];

    public ?string $message = null;

    #[On('open-contact-modal')]
    public function open(int $contactId): void
    {
        $this->resetValidation();
        $this->message = null;
        $this->commentBody = '';
        $this->contactId = $contactId;
        $this->loadContact();
        $this->showModal = true;

        $this->dispatch('contact-modal-opened');
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->dispatch('contact-modal-closed');
    }

    public function saveContact(): void
    {
        $this->message = null;
        $data = $this->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:64'],
            'companyName' => ['nullable', 'string', 'max:255'],
            'startDate' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:10000'],
        ]);

        $contact = Contact::query()->findOrFail($this->contactId);
        $normalizedPhone = $this->normalizePhone($data['phone'] ?? null);
        if ($normalizedPhone && Contact::query()
            ->where('phone_normalized', $normalizedPhone)
            ->where('id', '!=', $contact->id)
            ->exists()) {
            $this->addError('phone', 'Этот номер уже привязан к другому контакту.');

            return;
        }

        $contact->update([
            'name' => $data['name'] ?: null,
            'phone' => $data['phone'] ?: null,
            'phone_normalized' => $normalizedPhone,
            'company_name' => $data['companyName'] ?: null,
            'start_date' => $data['startDate'] ?: null,
            'notes' => $data['notes'] ?: null,
        ]);

        $this->message = 'Данные абонента сохранены.';
        $contact = $contact->fresh();
        $this->dispatch(
            'contact-updated',
            id: $contact->id,
            displayName: $contact->display_name,
            name: $contact->name,
            phone: $contact->phone,
            companyName: $contact->company_name,
            startDateLabel: $contact->start_date?->format('d.m.Y'),
        );
    }

    public function addComment(): void
    {
        $this->message = null;
        $data = $this->validate([
            'commentBody' => ['required', 'string', 'max:10000'],
        ]);

        Contact::query()->findOrFail($this->contactId)
            ->comments()
            ->create(['body' => $data['commentBody']]);

        $this->commentBody = '';
        $this->resetValidation('commentBody');
        $this->loadComments();
        $this->message = 'Комментарий добавлен.';
    }

    public function render()
    {
        return view('livewire.cals.contact-modal');
    }

    private function loadContact(): void
    {
        $contact = Contact::query()->findOrFail($this->contactId);
        $this->name = $contact->name;
        $this->phone = $contact->phone;
        $this->companyName = $contact->company_name;
        $this->startDate = $contact->start_date?->format('Y-m-d');
        $this->notes = $contact->notes;

        $this->loadComments();
    }

    private function loadComments(): void
    {
        $this->comments = Contact::query()
            ->findOrFail($this->contactId)
            ->comments()
            ->latest()
            ->get()
            ->map(fn ($comment) => [
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at?->format('d.m.Y · H:i'),
            ])
            ->all();
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 10) {
            return '7'.$digits;
        }
        if (strlen($digits) === 11 && $digits[0] === '8') {
            return '7'.substr($digits, 1);
        }

        return strlen($digits) >= 10 ? $digits : null;
    }
}
