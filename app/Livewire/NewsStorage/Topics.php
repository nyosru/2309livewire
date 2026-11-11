<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsTopic;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Topics extends Component
{
    public ?int $editingId = null;

    public string $name_ru = '';

    public string $name_en = '';

    public bool $is_active = true;

    public ?string $message = null;

    public function edit(int $id): void
    {
        Gate::authorize('manage-stn-news');

        $topic = NewsTopic::findOrFail($id);
        $this->editingId = $topic->id;
        $this->name_ru = $topic->name_ru;
        $this->name_en = $topic->name_en;
        $this->is_active = $topic->is_active;
    }

    public function save(): void
    {
        Gate::authorize('manage-stn-news');

        $nameRuUnique = Rule::unique('news_topics', 'name_ru');
        $nameEnUnique = Rule::unique('news_topics', 'name_en');
        if ($this->editingId) {
            $nameRuUnique->ignore($this->editingId);
            $nameEnUnique->ignore($this->editingId);
        }

        $data = $this->validate([
            'name_ru' => ['required', 'string', 'max:255', $nameRuUnique],
            'name_en' => ['required', 'string', 'max:255', $nameEnUnique],
            'is_active' => ['boolean'],
        ]);

        if ($this->editingId) {
            NewsTopic::findOrFail($this->editingId)->update($data);
        } else {
            NewsTopic::create($data);
        }

        $this->resetForm();
        $this->message = 'Тема сохранена';
    }

    public function toggleActive(int $id): void
    {
        Gate::authorize('manage-stn-news');

        $topic = NewsTopic::findOrFail($id);
        $topic->update(['is_active' => ! $topic->is_active]);
    }

    public function delete(int $id): void
    {
        Gate::authorize('manage-stn-news');

        NewsTopic::findOrFail($id)->delete();
        if ($this->editingId === $id) {
            $this->resetForm();
        }
        $this->message = 'Тема удалена';
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name_ru', 'name_en']);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.news-storage.topics', [
            'topics' => NewsTopic::withCount('news')->orderBy('name_ru')->get(),
        ])->layout('livewire.news-storage.layouts.app-component', [
            'title' => 'Темы новостей',
        ]);
    }
}
