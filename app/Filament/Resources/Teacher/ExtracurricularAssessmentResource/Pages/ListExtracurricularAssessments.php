<?php

namespace App\Filament\Resources\Teacher\ExtracurricularAssessmentResource\Pages;

use App\Filament\Resources\Teacher\ExtracurricularAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtracurricularAssessments extends ListRecords
{
    protected static string $resource = ExtracurricularAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
