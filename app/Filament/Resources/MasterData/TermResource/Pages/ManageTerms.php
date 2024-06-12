<?php

namespace App\Filament\Resources\MasterData\TermResource\Pages;

use App\Filament\Resources\MasterData\TermResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTerms extends ManageRecords
{
    protected static string $resource = TermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
