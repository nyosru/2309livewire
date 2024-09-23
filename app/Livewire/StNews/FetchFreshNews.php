<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class FetchFreshNews extends Component
{
    public function fetchNews()
    {
        $rssFeed = Http::get('https://tyumen-news.net/rss/news');
        $rss = simplexml_load_string($rssFeed->body());

        foreach ($rss->channel->item as $item) {
            $title = (string)$item->title;
            $content = (string)$item->description;
            $publishedAt = date('Y-m-d H:i:s', strtotime((string)$item->pubDate));
            $sourceLink = (string)$item->link; // Ссылка на конкретную новость

            // Проверка на наличие новости с таким же заголовком и ссылкой, чтобы избежать дублирования
            $existingNews = StNews::where('source', $sourceLink)->first();

            if (!$existingNews) {
                StNews::create([
                    'title' => $title,
                    'content' => $content,
                    'published_at' => $publishedAt,
                    'source' => $sourceLink, // Сохраняем ссылку на источник
                    'moderation' => false, // Статус модерации по умолчанию
                    'moderation_required' => true,
                ]);
            }
        }

        // Обновить страницу после загрузки новостей
        session()->flash('message', 'Новости успешно загружены!');
    }

    public function render()
    {
        return view('livewire.st-news.fetch-fresh-news');
    }
}
