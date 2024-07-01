<?php

namespace App\Filament\Resources\MasterData\TkTopicResource\Pages;

use App\Filament\Resources\MasterData\TkTopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTkTopics extends ListRecords
{
    protected static string $resource = TkTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
