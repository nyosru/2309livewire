<?php

namespace App\Livewire\Phpcatru;

use App\Services\BlogService;
use Livewire\Component;

class BlogInformer extends Component
{
    public array $posts = [];

    public function mount(BlogService $blogService)
    {
        $this->posts = $blogService->getLatestPosts(2);
    }

    public function render()
    {
        return view('livewire.phpcatru.blog-informer');
    }
}
