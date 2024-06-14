<?php

namespace App\Filament\Resources\MasterData\ClassSchoolResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\MasterData\ClassSchoolResource;

class ViewClassSchool extends ViewRecord
{
    protected static string $resource = ClassSchoolResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
