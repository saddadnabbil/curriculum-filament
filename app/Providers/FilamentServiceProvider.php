<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class FilamentServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any application services.
    }

    public function boot()
    {
        // Register the Livewire PanelSwitcher component in the top navigation
        Filament::serving(function () {
            Filament::registerRenderHook(
                'header.end',
                fn() => \Livewire\Livewire::mount('panel-switcher')->html()
            );
        });
    }
}
