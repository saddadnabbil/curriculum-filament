<?php

namespace App\Filament\Resources\EmployeeUnitResource\Pages;

use App\Filament\Resources\EmployeeUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeUnits extends ManageRecords
{
    protected static string $resource = EmployeeUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
