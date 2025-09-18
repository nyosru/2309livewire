<?php

namespace App\Livewire\Phpcatcom\News;

use App\Models\News;
use Livewire\Component;

class NewsShow extends Component
{
    public $news;
    public $slug;
    public $layout;

    public function mount($slug)
    {
        $this->layout = 'livewire.cfa.app.body';

        $this->slug = $slug;
        $this->loadNews();
    }

    protected function loadNews()
    {
        $this->news = News::published()
            ->where('slug', $this->slug)
            ->firstOrFail();

        // Увеличиваем счетчик просмотров
        $this->news->incrementViews();
    }

    public function render()
    {
        $view = view('livewire.phpcatcom.news.news-show', [
            'newsItem' => $this->news,
        ]);

        return $this->layout ? $view->layout($this->layout) : $view;
    }
}
