<?php

namespace App\Filament\Resources\Teacher\ExtracurricularAssessmentResource\Pages;

use App\Filament\Resources\Teacher\ExtracurricularAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtracurricularAssessment extends EditRecord
{
    protected static string $resource = ExtracurricularAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
