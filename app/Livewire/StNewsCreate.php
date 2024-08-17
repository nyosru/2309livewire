<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\StNews;
use App\Models\StNewsPhoto;
use Livewire\WithFileUploads;

class StNewsCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $published_at;
    public $photos = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'published_at' => 'required|date',
        'photos.*' => 'image|max:1024', // максимум 1 МБ для каждой фотографии
    ];

    public function submit()
    {
        $this->validate();

        $news = StNews::create([
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => $this->published_at,
        ]);

        if ($this->photos) {
            foreach ($this->photos as $photo) {
                $path = $photo->store('images', 'public');
                StNewsPhoto::create([
                    'st_news_id' => $news->id,
                    'image_path' => $path,
                ]);
            }
        }

        session()->flash('message', 'Новость успешно добавлена!');
//        return redirect()->route('news.index'); // перенаправление на список новостей
        return redirect('/'); // перенаправление на список новостей
    }

    public function render()
    {
        return view('livewire.st-news-create');
    }
}
