<?php

namespace App\Filament\Resources\SuperAdmin\EmployeeUnitResource\Pages;

use App\Filament\Resources\SuperAdmin\EmployeeUnitResource;
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
