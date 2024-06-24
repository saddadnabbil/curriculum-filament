<?php

namespace App\Filament\Resources\Teacher\GradingResource\Pages;

use App\Filament\Resources\Teacher\GradingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrading extends EditRecord
{
    protected static string $resource = GradingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
