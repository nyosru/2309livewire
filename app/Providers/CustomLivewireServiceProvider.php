<?php

namespace App\Providers;

use Illuminate\Support\Facades\Livewire;
use Illuminate\Foundation\Support\Providers\LivewireServiceProvider as ServiceProvider;

class CustomLivewireServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any services here...
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Override the default layout for all components
        if (strtolower($_SERVER['HTTP_HOST']) == 'stn.local') {
            Livewire::getRenderer()->setDefaultLayout('my_custom_layout');
        }
    }
}
