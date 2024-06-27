<?php

namespace App\Filament\Resources\MasterData\TkPointResource\Pages;

use App\Filament\Resources\MasterData\TkPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTkPoints extends ListRecords
{
    protected static string $resource = TkPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
