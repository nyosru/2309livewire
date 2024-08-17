<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\StNews;
use App\Models\StNewsPhoto;

class StNewsCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $summary;
    public $content;
    public $published_at;
    public $promo_code;
    public $photos = [];

    public function createNews()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'published_at' => 'required|date',
            'photos.*' => 'image|max:1024', // максимум 1MB на файл
        ]);

        $news = StNews::create([
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'promo_code' => $this->promo_code,
        ]);

        foreach ($this->photos as $photo) {
            $path = $photo->store('images', 'public');
            StNewsPhoto::create([
                'st_news_id' => $news->id,
                'image_path' => $path,
            ]);
        }

        // Очистка полей после добавления
        $this->reset(['title', 'summary', 'content', 'published_at', 'promo_code', 'photos']);

        session()->flash('message', 'Новость успешно добавлена.');
    }

    public function render()
    {
        return view('livewire.st-news-create');
    }
}
