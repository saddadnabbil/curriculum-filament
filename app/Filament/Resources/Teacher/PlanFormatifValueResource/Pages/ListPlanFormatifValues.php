<?php

namespace App\Filament\Resources\Teacher\PlanFormatifValueResource\Pages;

use App\Filament\Resources\Teacher\PlanFormatifValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanFormatifValues extends ListRecords
{
    protected static string $resource = PlanFormatifValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
