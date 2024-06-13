<?php

namespace App\Filament\Resources\MasterData\TeacherResource\Pages;

use App\Filament\Resources\MasterData\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTeachers extends ManageRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
