<?php

namespace App\Filament\Resources\Teacher\TkAchivementGradeResource\Pages;

use App\Filament\Resources\Teacher\TkAchivementGradeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTkAchivementGrade extends EditRecord
{
    protected static string $resource = TkAchivementGradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
