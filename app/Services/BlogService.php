<?php

namespace App\Services;

use App\Models\PhpcatruBlog;
use App\Repositories\BlogRepository;

class BlogService
{
    public function __construct(
        protected BlogRepository $blogRepository
    ) {}

    public function getAllPosts(): array
    {
        return $this->blogRepository
            ->getAllPublished()
            ->map(fn (PhpcatruBlog $post) => $this->formatListItem($post))
            ->toArray();
    }

    public function getPostBySlug(string $slug): ?array
    {
        $post = $this->blogRepository->getBySlug($slug);

        if (! $post) {
            return null;
        }

        return $this->formatDetail($post);
    }

    public function getLatestPosts(int $limit = 2): array
    {
        return $this->blogRepository
            ->getLatest($limit)
            ->map(fn (PhpcatruBlog $post) => $this->formatInformerItem($post))
            ->toArray();
    }

    private function formatListItem(PhpcatruBlog $post): array
    {
        return [
            'slug' => $post->slug,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'tag' => $post->tag,
            'date' => $this->formatDate($post->published_at),
        ];
    }

    private function formatDetail(PhpcatruBlog $post): array
    {
        return [
            'title' => $post->title,
            'tag' => $post->tag,
            'date' => $this->formatDate($post->published_at),
            'content' => explode("\n\n", $post->content),
        ];
    }

    private function formatInformerItem(PhpcatruBlog $post): array
    {
        return [
            'slug' => $post->slug,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'published_at' => $this->formatDate($post->published_at),
        ];
    }

    private function formatDate($date): string
    {
        if (! $date) {
            return '';
        }

        $months = [
            'January' => 'января',
            'February' => 'февраля',
            'March' => 'марта',
            'April' => 'апреля',
            'May' => 'мая',
            'June' => 'июня',
            'July' => 'июля',
            'August' => 'августа',
            'September' => 'сентября',
            'October' => 'октября',
            'November' => 'ноября',
            'December' => 'декабря',
        ];

        $timestamp = $date instanceof \Carbon\Carbon ? $date : \Carbon\Carbon::parse($date);
        $day = $timestamp->format('j');
        $month = $months[$timestamp->format('F')];
        $year = $timestamp->format('Y');

        return "$day $month $year";
    }
}
