<?php

namespace App\Filament\Imports\MasterData;

use App\Models\Subject;
use App\Models\AcademicYear;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class SubjectImporter extends Importer
{
    protected static ?string $model = Subject::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('academic_year_id')
                ->label('Academic Year')
                ->fillRecordUsing(function (Subject $record, ?string $state): void {
                    $year = AcademicYear::where('year', $state)->first();
                    $record->academic_year_id = $year ? $year->id : null;
                })
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->label('Subject Name (English)')
                ->rules(['max:255']),
            ImportColumn::make('name_idn')
                ->label('Subject Name (Indonesia)')
                ->rules(['max:255']),
            ImportColumn::make('slug')
                ->rules(['max:255']),
            ImportColumn::make('color')
                ->rules(['max:255']),
        ];
    }

    protected function normalizeData(array $data): array
    {
        $normalizedData = [];
        $headerMap = [
            'academic_year' => 'academic_year_id',
        ];

        foreach ($data as $key => $value) {
            $normalizedKey = strtolower(trim(str_replace(' ', '_', $key)));
            if (isset($headerMap[$normalizedKey])) {
                $normalizedKey = $headerMap[$normalizedKey];
            }
            $normalizedData[$normalizedKey] = $value;
        }

        return $normalizedData;
    }

    public function resolveRecord(): ?Subject
    {
        $this->data = $this->normalizeData($this->data);

        // Get the academic year ID
        $academicYear = AcademicYear::where('year', $this->data['academic_year_id'])->first();
        $academicYearId = $academicYear ? $academicYear->id : null;

        // Find existing subject by academic_year_id and name, or create new
        $subject = Subject::firstOrNew([
            'academic_year_id' => $academicYearId,
            'name' => $this->data['name'],
        ]);

        // Update the subject attributes
        $subject->fill([
            'academic_year_id' => $academicYearId,
            'name' => $this->data['name'],
            'name_idn' => $this->data['name_idn'],
            'slug' => $this->data['slug'],
            'color' => $this->data['color'],
        ]);

        // Save the subject record
        $subject->save();

        return $subject;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your subject import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
