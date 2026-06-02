<?php

namespace App\Livewire\Phpcatru;

use App\Services\BlogService;
use Livewire\Component;

class BlogList extends Component
{
    public array $posts = [];

    public function mount(BlogService $blogService)
    {
        $this->posts = $blogService->getAllPosts();
    }

    public function render()
    {
        return view('livewire.phpcatru.blog-list')
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => 'Блог об ИИ — php-cat.ru',
            ]);
    }
}
