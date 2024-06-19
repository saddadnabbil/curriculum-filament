<?php

namespace App\Filament\Exports\MasterData;

use App\Models\MasterData\Extracurricular;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ExtracurricularExporter extends Exporter
{
    protected static ?string $model = Extracurricular::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('academicYear.year')
                ->formatStateUsing(function (Extracurricular $extracurricular) {
                    return $extracurricular->academicYear->year;
                }),
            ExportColumn::make('teacher.employee.fullname')
                ->label('Teacher Name')
                ->formatStateUsing(function (Extracurricular $extracurricular) {
                    return $extracurricular->teacher->employee->fullname;
                }),
            ExportColumn::make('name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your extracurricular export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
