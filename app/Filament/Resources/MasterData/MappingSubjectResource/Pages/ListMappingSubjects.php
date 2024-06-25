<?php

namespace App\Filament\Resources\MasterData\MappingSubjectResource\Pages;

use App\Filament\Resources\MasterData\MappingSubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMappingSubjects extends ListRecords
{
    protected static string $resource = MappingSubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
