<?php

namespace App\Filament\Resources\Teacher\StudentDataResource\Pages;

use App\Filament\Resources\Teacher\StudentDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentData extends EditRecord
{
    protected static string $resource = StudentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
