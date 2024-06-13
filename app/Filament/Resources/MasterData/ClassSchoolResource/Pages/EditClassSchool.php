<?php

namespace App\Filament\Resources\MasterData\ClassSchoolResource\Pages;

use App\Filament\Resources\MasterData\ClassSchoolResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassSchool extends EditRecord
{
    protected static string $resource = ClassSchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
