<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use App\Models\Krugi\CupPhoto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class Admin extends Component
{
    use WithFileUploads;

    public $editId;

    public $name = '';

    public $lat = '';

    public $lon = '';

    public $address = '';

    public $geocodeResult = '';

    public $opis = '';

    public $img = [];

    public $photoLink = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'lat' => 'nullable|string|max:255',
            'lon' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'opis' => 'nullable|string',
            'img.*' => 'nullable|image|max:2048',
            'photoLink' => 'nullable|url|max:2048',
        ]);

        $wasEditing = (bool) $this->editId;
        $cup = $wasEditing ? Cup::findOrFail($this->editId) : new Cup;

        $cup->name = $this->name;
        $cup->lat = $this->lat;
        $cup->lon = $this->lon;
        $cup->address = $this->address;
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
        session()->flash('success', $wasEditing ? 'Кружка обновлена!' : 'Кружка успешно добавлена!');
    }

    public function findCoordinates(): void
    {
        $this->resetErrorBag('address');
        $this->geocodeResult = '';

        $address = trim($this->address);

        if ($address === '') {
            $this->addError('address', 'Сначала введите адрес.');

            return;
        }

        try {
            $places = Cache::remember(
                'cups:geocode:'.sha1(mb_strtolower($address)),
                now()->addDays(30),
                function () use ($address): array {
                    $response = Http::acceptJson()
                        ->withHeaders([
                            'Referer' => 'https://cups.php-cat.ru/a123_',
                            'User-Agent' => 'cups.php-cat.ru/1.0',
                        ])
                        ->timeout(12)
                        ->get(rtrim(config('services.nominatim.url'), '/').'/search', [
                            'q' => $address,
                            'format' => 'jsonv2',
                            'limit' => 1,
                            'accept-language' => 'ru',
                        ]);

                    $response->throw();

                    return $response->json() ?: [];
                }
            );
        } catch (Throwable) {
            $this->addError('address', 'Сервис поиска координат сейчас недоступен. Попробуйте позже.');

            return;
        }

        $place = $places[0] ?? null;

        if (! $place || ! isset($place['lat'], $place['lon'])) {
            $this->addError('address', 'По этому адресу не удалось найти координаты.');

            return;
        }

        $this->lat = (string) $place['lat'];
        $this->lon = (string) $place['lon'];
        $this->geocodeResult = (string) ($place['display_name'] ?? $address);
    }

    public function edit($id)
    {
        $cup = Cup::findOrFail($id);

        $this->editId = $cup->id;
        $this->name = $cup->name;
        $this->lat = $cup->lat;
        $this->lon = $cup->lon;
        $this->address = $cup->address;
        $this->geocodeResult = '';
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

    public function toggleHidden($id): void
    {
        $cup = Cup::findOrFail($id);
        $cup->is_hidden = ! $cup->is_hidden;
        $cup->save();

        session()->flash('success', $cup->is_hidden ? 'Кружка скрыта с сайта' : 'Кружка снова показывается на сайте');
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
        $this->address = '';
        $this->geocodeResult = '';
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
            'cups' => Cup::with('photos')->orderByDesc('id')->get(),
        ])->layout('livewire.cups.app.body');
    }
}
