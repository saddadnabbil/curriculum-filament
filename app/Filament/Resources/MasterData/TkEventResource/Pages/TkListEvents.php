<?php

namespace App\Filament\Resources\MasterData\TkEventResource\Pages;

use App\Filament\Resources\MasterData\TkEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class TkListEvents extends ListRecords
{
    protected static string $resource = TkEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
