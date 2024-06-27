<?php

namespace App\Filament\Resources\MasterData\TkElementResource\Pages;

use App\Filament\Resources\MasterData\TkElementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTkElements extends ListRecords
{
    protected static string $resource = TkElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
