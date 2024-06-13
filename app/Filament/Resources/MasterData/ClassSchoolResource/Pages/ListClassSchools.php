<?php

namespace App\Filament\Resources\MasterData\ClassSchoolResource\Pages;

use App\Filament\Resources\MasterData\ClassSchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassSchools extends ListRecords
{
    protected static string $resource = ClassSchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
