<?php

namespace App\Filament\Resources\MasterData\TkSubtopicResource\Pages;

use App\Filament\Resources\MasterData\TkSubtopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTkSubtopics extends ListRecords
{
    protected static string $resource = TkSubtopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
