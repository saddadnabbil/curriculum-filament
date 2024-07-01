<?php

namespace App\Filament\Resources\Teacher\PancasilaRaportProjectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Teacher\PancasilaRaportProjectResource;
use App\Filament\Resources\PancasilaRaportProjectResource\Pages\PancasilaRaportProjectTree;

class ManagePancasilaRaportProjects extends ManageRecords
{
    protected static string $resource = PancasilaRaportProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('tree_page')
                ->outlined()
                ->url(PancasilaRaportProjectResource::getUrl() . '/tree-list')
        ];
    }
}
