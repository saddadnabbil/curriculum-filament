<?php

namespace App\Filament\Resources\MasterData\ExtracurricularResource\Pages;

use App\Filament\Resources\MasterData\ExtracurricularResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtracurricular extends EditRecord
{
    protected static string $resource = ExtracurricularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
