<?php

namespace App\Filament\Resources\Teacher\LearningOutcomeResource\Pages;

use App\Filament\Resources\Teacher\LearningOutcomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLearningOutcomes extends ListRecords
{
    protected static string $resource = LearningOutcomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
