<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use Livewire\Component;

class LatestCup extends Component
{
    public ?Cup $cup = null;

    public ?string $mapUrl = null;

    public ?string $advertisingMapUrl = null;

    public ?string $telephoneUrl = null;

    public bool $showAdvertisement = false;

    public function mount(): void
    {
        $this->cup = Cup::with('photos')
            ->where('is_hidden', false)
            ->latest('id')
            ->first();

        if ($this->cup && $this->hasValidCoordinates($this->cup)) {
            $latitude = str_replace(',', '.', trim((string) $this->cup->lat));
            $longitude = str_replace(',', '.', trim((string) $this->cup->lon));

            $this->mapUrl = sprintf(
                'https://yandex.ru/maps/?pt=%s&z=15&l=map',
                rawurlencode($longitude.','.$latitude)
            );
        }

        $this->showAdvertisement = (bool) $this->cup?->show_advertisement
            && (
                filled($this->cup?->advertising_text)
                || filled($this->cup?->advertising_address)
                || filled($this->cup?->advertising_phone)
            );

        if ($this->showAdvertisement) {
            $advertisingAddress = trim((string) $this->cup->advertising_address);
            $advertisingPhone = trim((string) $this->cup->advertising_phone);

            if ($advertisingAddress !== '') {
                $this->advertisingMapUrl = 'https://yandex.ru/maps/?'.http_build_query([
                    'text' => $advertisingAddress,
                ]);
            }

            if ($advertisingPhone !== '') {
                $startsWithPlus = str_starts_with($advertisingPhone, '+');
                $phoneDigits = preg_replace('/\D+/', '', $advertisingPhone);

                if ($phoneDigits !== '') {
                    $this->telephoneUrl = 'tel:'.($startsWithPlus ? '+' : '').$phoneDigits;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.cups.latest-cup');
    }

    private function hasValidCoordinates(Cup $cup): bool
    {
        $latitude = str_replace(',', '.', trim((string) $cup->lat));
        $longitude = str_replace(',', '.', trim((string) $cup->lon));

        return is_numeric($latitude)
            && is_numeric($longitude)
            && (float) $latitude >= -90
            && (float) $latitude <= 90
            && (float) $longitude >= -180
            && (float) $longitude <= 180;
    }
}
