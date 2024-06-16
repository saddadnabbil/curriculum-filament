<?php

namespace App\Filament\Resources\MasterData\SilabusResource\Pages;

use App\Filament\Resources\MasterData\SilabusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSilabus extends ViewRecord
{
    protected static string $resource = SilabusResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
