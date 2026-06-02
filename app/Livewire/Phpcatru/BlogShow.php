<?php

namespace App\Livewire\Phpcatru;

use App\Services\BlogService;
use Livewire\Component;

class BlogShow extends Component
{
    public string $slug;

    public ?array $post = null;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render(BlogService $blogService)
    {
        $this->post = $blogService->getPostBySlug($this->slug);

        if (! $this->post) {
            return redirect('/blog');
        }

        return view('livewire.phpcatru.blog-show', ['post' => $this->post])
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => $this->post['title'].' — php-cat.ru',
            ]);
    }
}
