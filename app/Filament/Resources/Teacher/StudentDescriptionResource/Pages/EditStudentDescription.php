<?php

namespace App\Filament\Resources\Teacher\StudentDescriptionResource\Pages;

use App\Filament\Resources\Teacher\StudentDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentDescription extends EditRecord
{
    protected static string $resource = StudentDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
