<?php

namespace App\Filament\Resources\SuperAdmin\EmployeePositionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\SuperAdmin\EmployeePositionResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ManageEmployeePositions extends ManageRecords
{
    protected static string $resource = EmployeePositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
