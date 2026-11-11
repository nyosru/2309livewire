<?php

namespace App\Livewire\StNews;

use App\Models\NewsStorageNews;
use App\Models\NewsTopic;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ModerateNews extends Component
{
    public $newsToModerate;

    public array $selectedTopics = [];

    public function mount()
    {
        // Получаем новости, которые нуждаются в модерации
        $this->newsToModerate = NewsStorageNews::stn()->where('moderation_required', true)
            ->whereNull('moderation')
            ->with('topics')
            ->get();

        $this->selectedTopics = $this->newsToModerate->mapWithKeys(function ($news) {
            $selected = $news->topics
                ->filter(fn ($topic) => $topic->is_active)
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->all();

            return [$news->id => $selected];
        })->all();
    }

    public function render()
    {
        return view('livewire.st-news.moderate-news', [
            'newsToModerate' => $this->newsToModerate,
            'topics' => NewsTopic::active()->orderBy('name_ru')->get(),
        ])->layout('livewire.news-storage.layouts.app-component', [
            'title' => 'Модерация новостей',
        ]);
    }

    public function toggleSelectedTopic(int $newsId, int $topicId, bool $selected): void
    {
        if (! array_key_exists($newsId, $this->selectedTopics)) {
            $this->selectedTopics[$newsId] = [];
        }

        $selectedIds = collect($this->selectedTopics[$newsId])
            ->map(fn ($id) => (int) $id)
            ->reject(fn ($id) => $id === $topicId);

        if ($selected) {
            $selectedIds->push($topicId);
        }

        $this->selectedTopics[$newsId] = $selectedIds->unique()->values()->all();
    }

    public function approve($newsId)
    {
        Gate::authorize('moderate-news-storage');

        $news = NewsStorageNews::resolveLegacyOrCurrent($newsId);
        $selectedIds = collect($this->selectedTopics[$news->id] ?? [])
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        $validIds = NewsTopic::active()->whereIn('id', $selectedIds)->pluck('id');

        if ($validIds->count() !== $selectedIds->count()) {
            $this->addError('topics', 'Выбранная тема отключена или больше не существует. Обновите страницу.');
            return;
        }

        $news->topics()->sync($selectedIds->all());

        $news->moderation = true; // Одобрено
        $news->moderation_date = now();
        $news->moderation_who = auth()->id(); // ID пользователя, который одобрил
        $news->save();

        $this->mount(); // Обновляем список новостей после модерации
    }

    public function reject($newsId)
    {
        Gate::authorize('moderate-news-storage');

        $news = NewsStorageNews::resolveLegacyOrCurrent($newsId);
        $news->moderation = false; // Отклонено
        $news->moderation_date = now();
        $news->moderation_who = auth()->id(); // ID пользователя, который отклонил
        $news->save();

        $this->mount(); // Обновляем список новостей после модерации
    }
}
