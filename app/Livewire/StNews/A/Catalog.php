<?php

namespace App\Livewire\StNews\A;

use App\Models\StNewsParsingCategory;
use Livewire\Component;

class Catalog extends Component
{
    public $categories = [];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        // Загружаем все категории
        $this->categories = StNewsParsingCategory::all();
    }

    // Метод для переключения статуса сканирования
    public function toggleScanStatus($categoryId)
    {
        $category = StNewsParsingCategory::find($categoryId);
        if ($category) {
            // Переключаем статус между true и false
            $category->scan_status = !$category->scan_status;
            $category->save();

            // Обновляем список категорий после изменения
            $this->loadCategories();
        }
    }

    public function render()
    {
        return view('livewire.st-news.a.catalog');
    }
}
