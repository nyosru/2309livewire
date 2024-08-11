<?php

namespace App\Livewire\Afisha;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AfishaPoster as Poster;
use App\Models\AfishaImage;

class AddForm extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $link;
    public $event_date;
    public $event_time;
    public $end_date;
    public $source_link;
    public $extra_links = [];
    public $images = [];  // Для хранения загруженных файлов

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'link' => 'nullable|url',
        'event_date' => 'nullable|date',
        'event_time' => 'nullable|date_format:H:i',
        'end_date' => 'nullable|date',
        'source_link' => 'nullable|url',
        'extra_links.*.link' => 'nullable|url',
        'extra_links.*.text' => 'nullable|string|max:255',
        'images.*' => 'nullable|image|max:1024',  // Ограничение на размер изображения
    ];

    public function addPoster()
    {
        $this->validate();

        // Создание новой афиши
        $poster = Poster::create([
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'end_date' => $this->end_date,
            'source_link' => $this->source_link,
            'extra_links' => $this->extra_links,
        ]);

        // Сохранение изображений и привязка их к афише
        foreach ($this->images as $image) {
            $imagePath = $image->store('afisha-img', 'public');  // Сохраняем изображения в нужную директорию

            AfishaImage::create([
                'poster_id' => $poster->id,
                'path' => $imagePath,
            ]);
        }

        session()->flash('message', 'Афиша добавлена успешно.');

        $this->reset();  // Сбрасываем все свойства формы
    }

    public function render()
    {
        return view('livewire.afisha.add-form');
    }
}
