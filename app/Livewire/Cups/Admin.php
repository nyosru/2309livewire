<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use App\Models\Krugi\CupPhoto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

    public $advertisingText = '';

    public $advertisingAddress = '';

    public $advertisingPhone = '';

    public $showAdvertisement = false;

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
            'advertisingText' => 'nullable|string',
            'advertisingAddress' => 'nullable|string|max:500',
            'advertisingPhone' => 'nullable|string|max:100',
            'showAdvertisement' => 'boolean',
            'img' => 'array|max:10',
            'img.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:12288',
            'photoLink' => 'nullable|url|max:2048',
        ]);

        $wasEditing = (bool) $this->editId;
        $cup = $wasEditing ? Cup::findOrFail($this->editId) : new Cup;

        $cup->name = $this->name;
        $cup->lat = $this->lat;
        $cup->lon = $this->lon;
        $cup->address = $this->address;
        $cup->opis = $this->opis;
        $cup->advertising_text = $this->advertisingText;
        $cup->advertising_address = $this->advertisingAddress;
        $cup->advertising_phone = $this->advertisingPhone;
        $cup->show_advertisement = $this->showAdvertisement;

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
        $this->advertisingText = $cup->advertising_text;
        $this->advertisingAddress = $cup->advertising_address;
        $this->advertisingPhone = $cup->advertising_phone;
        $this->showAdvertisement = $cup->show_advertisement;
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

    public function rotatePhoto($photoId): void
    {
        $photo = CupPhoto::findOrFail($photoId);

        if (! $photo->image) {
            session()->flash('error', 'Фотографию по внешней ссылке повернуть нельзя.');

            return;
        }

        $oldFilename = $photo->image;
        $oldPath = storage_path('app/public/krugi/cups/'.$oldFilename);

        if (! is_file($oldPath)) {
            session()->flash('error', 'Исходный файл фотографии не найден.');

            return;
        }

        $newFilename = 'cup_tmp_'.Str::uuid().'.jpg';
        $newPath = storage_path('app/public/krugi/cups/'.$newFilename);

        if (! $this->rotateImageClockwise($oldPath, $newPath)
            || ! $this->makeMini($newPath, $newFilename)) {
            $this->deleteFiles($newFilename);
            session()->flash('error', 'Не удалось повернуть фотографию.');

            return;
        }

        try {
            $photo->image = $newFilename;
            $photo->save();
        } catch (Throwable) {
            $this->deleteFiles($newFilename);
            session()->flash('error', 'Не удалось сохранить повёрнутую фотографию.');

            return;
        }

        $this->deleteFiles($oldFilename);
        session()->flash('success', 'Фотография повёрнута на 90° по часовой стрелке.');
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

    public function toggleAdvertisement($id): void
    {
        $cup = Cup::findOrFail($id);
        $cup->show_advertisement = ! $cup->show_advertisement;
        $cup->save();

        session()->flash(
            'success',
            $cup->show_advertisement ? 'Рекламный блок включён' : 'Рекламный блок выключен'
        );
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
        $this->advertisingText = '';
        $this->advertisingAddress = '';
        $this->advertisingPhone = '';
        $this->showAdvertisement = false;
        $this->img = [];
        $this->photoLink = '';
    }

    private function storeImage($file): string
    {
        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp', 'image/gif'], true)) {
            throw ValidationException::withMessages([
                'img' => 'Этот формат изображения не поддерживается.',
            ]);
        }

        $filename = 'cup_tmp_'.Str::uuid().'.jpg';
        Storage::disk('public')->makeDirectory('krugi/cups');

        $storedImagePath = storage_path('app/public/krugi/cups/'.$filename);

        if (! $this->resizeImage($file->getRealPath(), $storedImagePath, 800)
            || ! $this->makeMini($storedImagePath, $filename)) {
            $this->deleteFiles($filename);

            throw ValidationException::withMessages([
                'img' => 'Не удалось сохранить изображение. Попробуйте выбрать другой файл.',
            ]);
        }

        return $filename;
    }

    private function makeMini(string $path, string $filename)
    {
        $dir = dirname($path).'/mini';
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        return $this->resizeImage(
            $path,
            $dir.'/'.$filename,
            400
        );
    }

    private function resizeImage(string $sourcePath, string $destinationPath, int $maxWidth): bool
    {
        $img = $this->loadImage($sourcePath);
        if (! $img) {
            return false;
        }

        $oldW = imagesx($img);
        $oldH = imagesy($img);
        $newW = min($maxWidth, $oldW);
        $newH = intval($oldH * $newW / $oldW);

        $resized = imagecreatetruecolor($newW, $newH);
        $white = imagecolorallocate($resized, 255, 255, 255);
        imagefill($resized, 0, 0, $white);
        imagealphablending($resized, true);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);

        $saved = imagejpeg($resized, $destinationPath, 80);

        imagedestroy($img);
        imagedestroy($resized);

        return $saved;
    }

    private function rotateImageClockwise(string $sourcePath, string $destinationPath): bool
    {
        $img = $this->loadImage($sourcePath);
        if (! $img) {
            return false;
        }

        $white = imagecolorallocate($img, 255, 255, 255);
        $rotated = imagerotate($img, -90, $white);
        imagedestroy($img);

        if (! $rotated) {
            return false;
        }

        $saved = imagejpeg($rotated, $destinationPath, 80);
        imagedestroy($rotated);

        return $saved;
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
