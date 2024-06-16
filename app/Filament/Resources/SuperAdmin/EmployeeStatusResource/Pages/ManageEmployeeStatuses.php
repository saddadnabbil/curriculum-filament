<?php

namespace App\Filament\Resources\SuperAdmin\EmployeeStatusResource\Pages;

use App\Filament\Resources\SuperAdmin\EmployeeStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeStatuses extends ManageRecords
{
    protected static string $resource = EmployeeStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
