<?php

namespace App\Filament\Resources\Teacher\PancasilaRaportProjectGroupResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Teacher\PancasilaRaportProjectGroupResource;

class ManagePancasilaRaportProjectGroups extends ManageRecords
{
    protected static string $resource = PancasilaRaportProjectGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
