<?php

namespace App\Filament\Resources\MasterData\SilabusResource\Pages;

use App\Filament\Resources\MasterData\SilabusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSilabus extends EditRecord
{
    protected static string $resource = SilabusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
