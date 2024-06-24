<?php

namespace App\Filament\Resources\Teacher\StudentAchievementResource\Pages;

use App\Filament\Resources\Teacher\StudentAchievementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentAchievements extends ListRecords
{
    protected static string $resource = StudentAchievementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
