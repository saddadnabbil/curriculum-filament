<?php

namespace App\Filament\Resources\Teacher\PrintReportSemesterResource\Pages;

use App\Filament\Resources\Teacher\PrintReportSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrintReportSemesters extends ListRecords
{
    protected static string $resource = PrintReportSemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
