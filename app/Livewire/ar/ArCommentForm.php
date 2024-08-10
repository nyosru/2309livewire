<?php

namespace App\Livewire\Ar;

use App\Models\ArComment;
use Livewire\Component;
use Livewire\WithPagination;

class ArCommentForm extends Component
{
    use WithPagination;

    public $comment;
    public $ar_object_id;
    public $ar_people_id;

    protected $rules = [
        'comment' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        ArComment::create([
            'comment' => $this->comment,
            'ar_object_id' => $this->ar_object_id,
            'ar_people_id' => $this->ar_people_id,
        ]);

        session()->flash('message', 'Комментарий успешно добавлен.');

        // Сброс формы после успешного добавления
        $this->reset('comment');
    }

    public function render()
    {
        $comments = ArComment::where('ar_object_id', $this->ar_object_id)
            ->when($this->ar_people_id, function ($query) {
                $query->where('ar_people_id', $this->ar_people_id);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.ar.ar-comment-form', [
            'comments' => $comments,
        ]);
    }
}
