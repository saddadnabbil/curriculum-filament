<?php

namespace App\Filament\Resources\Teacher\LegerResource\Pages;

use App\Filament\Resources\Teacher\LegerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLegers extends ListRecords
{
    protected static string $resource = LegerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
