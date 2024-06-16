<?php

namespace App\Filament\Resources\MasterData\SilabusResource\Pages;

use App\Filament\Resources\MasterData\SilabusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSilabuses extends ListRecords
{
    protected static string $resource = SilabusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
