<?php
namespace App\Livewire\StNews;

use Livewire\Component;
use App\Models\StNews;

class ModerationItem extends Component
{
    public $newsItem;  // Экземпляр новости
    public $decision;  // Решение по модерации ("approve" или "reject")

    public function mount(StNews $newsItem)
    {
        $this->newsItem = $newsItem;
        $this->decision = null;  // Изначально решение не принято
    }

    public function moderate($decision)
    {
        $this->decision = $decision;

        // Обновляем статус модерации в модели новости
        $this->newsItem->update([
            'moderation' => $decision === 'approve',
            'moderation_date' => now(),
            'moderation_who' => auth()->id(),  // Предполагается, что пользователь авторизован
            'needs_moderation' => false,  // Модерация завершена, больше не нужно
        ]);

        // Emit событие для родительского компонента, чтобы удалить новость из списка
        $this->emit('newsModerated', $this->newsItem->id);
    }

    public function render()
    {
        return view('livewire.st-news.moderation-item');
    }
}
