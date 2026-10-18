<?php

namespace App\Livewire\Ttt\Admin;

use App\Models\TttBilliardClub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Clubs extends Component
{
    use WithFileUploads;

    public ?int $editId = null;

    public string $name = '';

    public string $type = '';

    public string $address = '';

    public string $hours = '';

    public string $mapUrl = '';

    public int $sortOrder = 0;

    public bool $isActive = true;

    public $image = null;

    public ?string $currentImagePath = null;

    public function mount(): void
    {
        Gate::authorize('manage-ttt-clubs');
    }

    public function save(): void
    {
        $this->ensureAuthorized();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'hours' => ['required', 'string', 'max:255'],
            'mapUrl' => ['required', 'url', 'max:2048', 'starts_with:https://2gis.ru/'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:9999'],
            'isActive' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'mapUrl.starts_with' => 'Укажите ссылку на карточку или поиск клуба в 2ГИС.',
        ], [
            'name' => 'название',
            'type' => 'тип клуба',
            'address' => 'адрес',
            'hours' => 'часы работы',
            'mapUrl' => 'ссылка на 2ГИС',
            'sortOrder' => 'порядок',
            'isActive' => 'публикация',
            'image' => 'фотография',
        ]);

        $club = $this->editId
            ? TttBilliardClub::query()->findOrFail($this->editId)
            : new TttBilliardClub;

        $oldImagePath = $club->image_path;
        $imagePath = $oldImagePath;

        if ($this->image) {
            $imagePath = $this->image->store('ttt/clubs', 'public');
        }

        $club->fill([
            'name' => $validated['name'],
            'type' => $validated['type'] ?: null,
            'address' => $validated['address'],
            'hours' => $validated['hours'],
            'map_url' => $validated['mapUrl'],
            'sort_order' => $validated['sortOrder'],
            'is_active' => $validated['isActive'],
            'image_path' => $imagePath,
        ])->save();

        if ($this->image && $this->isManagedImage($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $message = $this->editId ? 'Клуб обновлён.' : 'Клуб добавлен.';

        $this->resetForm();
        session()->flash('success', $message);
    }

    public function edit(int $id): void
    {
        $this->ensureAuthorized();

        $club = TttBilliardClub::query()->findOrFail($id);

        $this->editId = $club->id;
        $this->name = $club->name;
        $this->type = $club->type ?? '';
        $this->address = $club->address;
        $this->hours = $club->hours;
        $this->mapUrl = $club->map_url;
        $this->sortOrder = $club->sort_order;
        $this->isActive = $club->is_active;
        $this->currentImagePath = $club->image_path;
        $this->image = null;
        $this->resetErrorBag();
    }

    public function delete(int $id): void
    {
        $this->ensureAuthorized();

        $club = TttBilliardClub::query()->findOrFail($id);
        $imagePath = $club->image_path;
        $club->delete();

        if ($this->isManagedImage($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        if ($this->editId === $id) {
            $this->resetForm();
        }

        session()->flash('success', 'Клуб удалён.');
    }

    public function toggleVisibility(int $id): void
    {
        $this->ensureAuthorized();

        $club = TttBilliardClub::query()->findOrFail($id);
        $club->update(['is_active' => ! $club->is_active]);

        if ($this->editId === $id) {
            $this->isActive = $club->is_active;
        }

        session()->flash('success', $club->is_active ? 'Клуб опубликован.' : 'Клуб скрыт.');
    }

    public function cancelEdit(): void
    {
        $this->ensureAuthorized();
        $this->resetForm();
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.ttt.admin.clubs', [
            'clubs' => TttBilliardClub::query()->ordered()->get(),
        ])->layout('ttt.layouts.admin');
    }

    public function imageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return '/storage/'.ltrim($path, '/');
    }

    private function ensureAuthorized(): void
    {
        Gate::authorize('manage-ttt-clubs');
    }

    private function isManagedImage(?string $path): bool
    {
        return $path !== null && str_starts_with($path, 'ttt/clubs/');
    }

    private function resetForm(): void
    {
        $this->reset([
            'editId',
            'name',
            'type',
            'address',
            'hours',
            'mapUrl',
            'image',
            'currentImagePath',
        ]);
        $this->sortOrder = 0;
        $this->isActive = true;
        $this->resetErrorBag();
    }
}
