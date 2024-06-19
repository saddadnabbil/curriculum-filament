<?php

namespace App\Filament\Exports\MasterData;

use App\Models\MasterData\Subject;
use Filament\Actions\Exports\Exporter;
use Illuminate\Database\Eloquent\Model;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;

class SubjectExporter extends Exporter
{
    protected static ?string $model = Subject::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('academicYear.year')
                ->formatStateUsing(function (Subject $subject) {
                    // Assuming roles is a Many-to-Many relationship
                    return $subject->academicYear->year;
                }),
            ExportColumn::make('name')
                ->label('Subject Name (English)'),
            ExportColumn::make('name_idn')
                ->label('Subject Name (Indonesia)'),
            ExportColumn::make('slug'),
            ExportColumn::make('color'),
        ];
    }

    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style())
            ->setFontBold()
            ->setFontSize(12)
            ->setFontName('Arial')
            ->setFontColor(Color::BLACK)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    }

    public function getXlsxCellStyle(): ?Style
    {
        return (new Style())
            ->setFontSize(12)
            ->setFontName('Arial');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your subject export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
