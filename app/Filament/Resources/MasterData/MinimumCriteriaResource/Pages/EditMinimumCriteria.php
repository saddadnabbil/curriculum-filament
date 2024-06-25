<?php

namespace App\Filament\Resources\MasterData\MinimumCriteriaResource\Pages;

use App\Filament\Resources\MasterData\MinimumCriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMinimumCriteria extends EditRecord
{
    protected static string $resource = MinimumCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
