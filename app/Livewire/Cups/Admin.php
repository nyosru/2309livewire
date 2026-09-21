<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use App\Models\Krugi\CupPhoto;
use Livewire\Component;
use Livewire\WithFileUploads;

class Admin extends Component
{
    use WithFileUploads;

    public $editId;

    public $name = '';

    public $lat = '';

    public $lon = '';

    public $opis = '';

    public $img = [];

    public $photoLink = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'lat' => 'nullable|string|max:255',
            'lon' => 'nullable|string|max:255',
            'opis' => 'nullable|string',
            'img.*' => 'nullable|image|max:2048',
            'photoLink' => 'nullable|url|max:2048',
        ]);

        $cup = $this->editId ? Cup::findOrFail($this->editId) : new Cup;

        $cup->name = $this->name;
        $cup->lat = $this->lat;
        $cup->lon = $this->lon;
        $cup->opis = $this->opis;

        $cup->save();

        $sort = (int) $cup->photos()->max('sort');

        foreach ($this->img as $file) {
            $cup->photos()->create([
                'image' => $this->storeImage($file),
                'link' => null,
                'sort' => ++$sort,
            ]);
        }

        if (! empty($this->photoLink)) {
            $cup->photos()->create([
                'image' => null,
                'link' => $this->photoLink,
                'sort' => ++$sort,
            ]);
        }

        $this->resetForm();
        session()->flash('success', $this->editId ? 'Кружка обновлена!' : 'Кружка успешно добавлена!');
    }

    public function edit($id)
    {
        $cup = Cup::findOrFail($id);

        $this->editId = $cup->id;
        $this->name = $cup->name;
        $this->lat = $cup->lat;
        $this->lon = $cup->lon;
        $this->opis = $cup->opis;
        $this->img = [];
        $this->photoLink = '';
    }

    public function deletePhoto($photoId)
    {
        $photo = CupPhoto::findOrFail($photoId);

        if ($photo->image) {
            $this->deleteFiles($photo->image);
        }

        $photo->delete();
    }

    public function delete($id)
    {
        $cup = Cup::findOrFail($id);

        foreach ($cup->photos as $photo) {
            if ($photo->image) {
                $this->deleteFiles($photo->image);
            }
        }

        $cup->delete();

        if ($this->editId == $id) {
            $this->resetForm();
        }

        session()->flash('success', 'Кружка удалена');
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->lat = '';
        $this->lon = '';
        $this->opis = '';
        $this->img = [];
        $this->photoLink = '';
    }

    private function storeImage($file): string
    {
        $filename = date('ymdhis').'_'.uniqid().'.jpg';

        $file->storeAs('krugi/cups', $filename, 'public');

        $this->makeMini(storage_path('app/public/krugi/cups/'.$filename), $filename);

        return $filename;
    }

    private function makeMini(string $path, string $filename)
    {
        $dir = dirname($path).'/mini';
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $img = $this->loadImage($path);
        if (! $img) {
            return false;
        }

        $oldW = imagesx($img);
        $oldH = imagesy($img);
        $newW = 400;
        $newH = intval($oldH * $newW / $oldW);

        $mini = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($mini, $img, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);

        imagejpeg($mini, $dir.'/'.$filename, 85);
        imagedestroy($img);
        imagedestroy($mini);

        return true;
    }

    private function loadImage(string $path)
    {
        $info = @getimagesize($path);
        if (! $info) {
            return false;
        }

        return match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => @imagecreatefromwebp($path),
            'image/gif' => @imagecreatefromgif($path),
            default => false,
        };
    }

    private function deleteFiles(string $filename)
    {
        foreach (['krugi/cups/'.$filename, 'krugi/cups/mini/'.$filename] as $rel) {
            $path = storage_path('app/public/'.$rel);
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }

    public function render()
    {
        return view('livewire.cups.admin', [
            'cups' => Cup::with('photos')->withTrashed()->orderByDesc('id')->get(),
        ])->layout('livewire.cups.app.body');
    }
}
