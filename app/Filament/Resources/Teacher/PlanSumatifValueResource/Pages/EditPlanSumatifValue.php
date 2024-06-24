<?php

namespace App\Filament\Resources\Teacher\PlanSumatifValueResource\Pages;

use App\Filament\Resources\Teacher\PlanSumatifValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanSumatifValue extends EditRecord
{
    protected static string $resource = PlanSumatifValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
