<?php

namespace App\Filament\Resources\Teacher\HomeroomNotesResource\Pages;

use App\Filament\Resources\Teacher\HomeroomNotesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeroomNotes extends EditRecord
{
    protected static string $resource = HomeroomNotesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
