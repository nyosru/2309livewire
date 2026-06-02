<?php

namespace App\Livewire\Phpcatru;

use App\Models\PhpcatruBlog;
use Livewire\Component;
use Illuminate\Support\Str;

class BlogCreate extends Component
{
    public $title = '';
    public $content = '';
    public $tag = '';
    public $excerpt = '';
    public $is_published = true;

    protected function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'tag' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        PhpcatruBlog::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'content' => $this->content,
            'tag' => $this->tag ?: null,
            'excerpt' => $this->excerpt ?: null,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? now() : null,
        ]);

        session()->flash('success', 'Запись успешно создана!');

        return redirect()->route('phpcat.blog');
    }

    public function render()
    {
        return view('livewire.phpcatru.blog-create')
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => 'Новая запись в блоге — php-cat.ru',
            ]);
    }
}
