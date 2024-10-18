<?php

namespace App\Livewire\StNews\A;

use App\Models\StNewsParsingSite;
use Livewire\Component;

class StNewsSiteItem extends Component
{
    public $site;

    // Метод для переключения статуса сканирования
    public function toggleScanStatus()
    {
        $this->site->scan_status = !$this->site->scan_status;
        $this->site->save();
        $this->site = $this->site->refresh();
    }

    // Метод для переключения модерации при загрузке
    public function toggleModerationOnUpload()
    {
        $this->site->moderation_on_upload = !$this->site->moderation_on_upload;
        $this->site->save();
        $this->site = $this->site->refresh();
    }

    public function render()
    {
        return view('livewire.st-news.a.st-news-site-item');
    }
}
