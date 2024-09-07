<?php
namespace App\Livewire\StNews;

use App\Models\StNewsPhoto;
use Livewire\Component;

class StNewsModerationImage extends Component
{
    public StNewsPhoto $image;
    public bool $deleted = false; // Переменная для отслеживания удаления

    public function delete(): void
    {
        $this->image->delete();
        $this->deleted = true; // Устанавливаем флаг удаления
    }

    public function render()
    {
        return view('livewire.st-news.st-news-moderation-image');
    }
}
