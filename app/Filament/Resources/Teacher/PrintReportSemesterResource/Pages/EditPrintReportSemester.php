<?php

namespace App\Filament\Resources\Teacher\PrintReportSemesterResource\Pages;

use App\Filament\Resources\Teacher\PrintReportSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrintReportSemester extends EditRecord
{
    protected static string $resource = PrintReportSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
