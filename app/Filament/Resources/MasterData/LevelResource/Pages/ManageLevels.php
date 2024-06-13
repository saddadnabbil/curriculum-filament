<?php

namespace App\Filament\Resources\MasterData\LevelResource\Pages;

use App\Filament\Resources\MasterData\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLevels extends ManageRecords
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
