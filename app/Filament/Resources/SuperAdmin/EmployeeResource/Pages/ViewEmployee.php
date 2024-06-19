<?php

namespace App\Filament\Resources\SuperAdmin\EmployeeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SuperAdmin\EmployeeResource;
use Illuminate\Database\Eloquent\Builder;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
