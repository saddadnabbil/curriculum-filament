<?php

namespace App\Filament\Exports;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Filament\Actions\Exports\Exporter;
use Illuminate\Database\Eloquent\Model;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Validation\ValidationException;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;

class EmployeeExporter extends Exporter
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('fullname'),
            ExportColumn::make('employee_code'),
            ExportColumn::make('user.email')
                ->label('Email')
                ->formatStateUsing(fn (?Model $record): string => $record->user?->email ?? ''),
            ExportColumn::make('user.roles.name')
                ->label('Roles'),
            ExportColumn::make('employee_status_id')
                ->label('Employee Status')
                ->formatStateUsing(fn (?Model $record): string => $record->employeeStatus?->name ?? ''),
            ExportColumn::make('employee_unit_id')
                ->label('Employee Unit')
                ->formatStateUsing(fn (?Model $record): string => $record->employeeUnit?->name ?? ''),
            ExportColumn::make('employee_position_id')
                ->label('Employee Position')
                ->formatStateUsing(fn (?Model $record): string => $record->employeePosition?->name ?? ''),
            ExportColumn::make('join_date'),
            ExportColumn::make('resign_date'),
            ExportColumn::make('permanent_date'),
            ExportColumn::make('nik'),
            ExportColumn::make('number_account'),
            ExportColumn::make('number_fingerprint'),
            ExportColumn::make('number_npwp'),
            ExportColumn::make('name_npwp'),
            ExportColumn::make('number_bpjs_ketenagakerjaan'),
            ExportColumn::make('iuran_bpjs_ketenagakerjaan'),
            ExportColumn::make('number_bpjs_yayasan'),
            ExportColumn::make('number_bpjs_pribadi'),
            ExportColumn::make('gender')
                ->formatStateUsing(fn (?string $state): string => Helper::getSex($state ?? '')),
            ExportColumn::make('religion')
                ->formatStateUsing(fn (?string $state): string => Helper::getReligion($state ?? '')),
            ExportColumn::make('place_of_birth'),
            ExportColumn::make('date_of_birth'),
            ExportColumn::make('address'),
            ExportColumn::make('address_now'),
            ExportColumn::make('city'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('phone_number'),
            ExportColumn::make('email_school'),
            ExportColumn::make('citizen'),
            ExportColumn::make('marital_status')
                ->formatStateUsing(fn (?string $state): string => Helper::getMaritalStatus($state ?? '')),
            ExportColumn::make('partner_name'),
            ExportColumn::make('number_of_childern'),
            ExportColumn::make('notes'),
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
            ->setCellVerticalAlignment(CellVerticalAlignment::CENTER)
            ->setBorder(new Border(
                new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN)
            ));
    }

    public function getXlsxCellStyle(): ?Style
    {
        return (new Style())
            ->setFontSize(12)
            ->setFontName('Arial')
            ->setBorder(new Border(
                new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN),
                new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN)
            ));
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employee export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
