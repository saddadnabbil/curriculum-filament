<?php

namespace App\Filament\Resources\MasterData\LearningDataResource\Pages;

use App\Filament\Resources\MasterData\LearningDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLearningData extends ManageRecords
{
    protected static string $resource = LearningDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
