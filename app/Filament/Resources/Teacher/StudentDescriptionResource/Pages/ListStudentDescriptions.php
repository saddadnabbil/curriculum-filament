<?php

namespace App\Filament\Resources\Teacher\StudentDescriptionResource\Pages;

use App\Filament\Resources\Teacher\StudentDescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentDescriptions extends ListRecords
{
    protected static string $resource = StudentDescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
