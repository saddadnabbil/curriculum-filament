<?php

namespace App\Providers;

use Livewire\Livewire;
use Filament\Facades\Filament;
use App\Livewire\AssessmentDropdown;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use App\Filament\Pages\Teacher\AchivementGrades;

class FilamentServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        // Register the Livewire PanelSwitcher component in the top navigation
        Filament::serving(function () {
            Filament::registerRenderHook(
                'header.end',
                fn () => \Livewire\Livewire::mount('panel-switcher')->html()
            );
        });
    }
}
