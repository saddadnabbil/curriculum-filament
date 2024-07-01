<?php

namespace App\Filament\Resources\TeacherPgKg\TkAchivementGradeResource\Pages;

use App\Filament\Resources\TeacherPgKg\TkAchivementGradeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTkAchivementGrades extends ListRecords
{
    protected static string $resource = TkAchivementGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
