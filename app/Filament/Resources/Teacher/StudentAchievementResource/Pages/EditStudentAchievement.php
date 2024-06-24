<?php

namespace App\Filament\Resources\Teacher\StudentAchievementResource\Pages;

use App\Filament\Resources\Teacher\StudentAchievementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentAchievement extends EditRecord
{
    protected static string $resource = StudentAchievementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
