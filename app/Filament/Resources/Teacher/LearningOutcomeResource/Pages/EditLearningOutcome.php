<?php

namespace App\Filament\Resources\Teacher\LearningOutcomeResource\Pages;

use App\Filament\Resources\Teacher\LearningOutcomeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLearningOutcome extends EditRecord
{
    protected static string $resource = LearningOutcomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
