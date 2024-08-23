<?php
namespace App\Livewire\StNews;

use Livewire\Component;
use App\Models\StNews;

class Moderation extends Component
{
    public $secret = '';
    public $news;

    protected $listeners = ['newsModerated' => 'removeNewsItem'];

    public function mount()
    {
        $this->news = collect(); // Начально пустая коллекция
    }

    public function updatedSecret()
    {
        if ($this->secret === config('app.secret_moderation')) {
            // Получаем новости, которые требуют модерации
            $this->news = StNews::where('needs_moderation', true)
                ->whereNull('moderation')
                ->get();
        } else {
            $this->news = collect(); // Если секрет неправильный, сбрасываем коллекцию
        }
    }

    public function removeNewsItem($id)
    {
        // Удаляем новость из списка после модерации
        $this->news = $this->news->filter(function ($item) use ($id) {
            return $item->id !== $id;
        });
    }

    public function render()
    {
        return view('livewire.st-news.moderation');
    }
}
