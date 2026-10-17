<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use Livewire\Component;

class CollectionMap extends Component
{
    public array $points = [];

    public function mount(): void
    {
        $this->points = Cup::query()
            ->with('photos')
            ->orderBy('id')
            ->get()
            ->map(fn (Cup $cup): array => $this->toMapPoint($cup))
            ->values()
            ->all();
    }

    private function toMapPoint(Cup $cup): array
    {
        $latitude = $this->coordinate($cup->lat, -90, 90);
        $longitude = $this->coordinate($cup->lon, -180, 180);
        $photo = $cup->photos->first();

        return [
            'id' => $cup->id,
            'name' => $cup->name,
            'description' => $cup->opis,
            'photo' => $photo?->mini_url,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }

    private function coordinate(?string $value, float $minimum, float $maximum): ?float
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $normalized = str_replace(',', '.', trim($value));

        if (! is_numeric($normalized)) {
            return null;
        }

        $coordinate = (float) $normalized;

        return $coordinate >= $minimum && $coordinate <= $maximum ? $coordinate : null;
    }

    public function cupWord(): string
    {
        $count = count($this->points);
        $lastTwoDigits = $count % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 14) {
            return 'кружек';
        }

        return match ($count % 10) {
            1 => 'кружка',
            2, 3, 4 => 'кружки',
            default => 'кружек',
        };
    }

    public function render()
    {
        return view('livewire.cups.collection-map');
    }
}
