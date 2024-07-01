<?php

namespace App\Filament\Imports\MasterData;

use App\Models;
use App\Models\Teacher;
use App\Models\Employee;
use App\Models\AcademicYear;
use App\Models\Extracurricular;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class ExtracurricularImporter extends Importer
{
    protected static ?string $model = Extracurricular::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('academic_year_id')
                ->label('Academic Year')
                ->fillRecordUsing(function (Extracurricular $record, ?string $state): void {
                    $year = AcademicYear::where('year', $state)->first();
                    $record->academic_year_id = $year ? $year->id : null;
                })
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('teacher_id')
                ->label('Teacher Name')
                ->fillRecordUsing(function (Extracurricular $record, ?string $state): void {
                    $employee = Employee::where('fullname', $state)->first();
                    $teacher = Teacher::where('employee_id', $employee ? $employee->id : null)->first();
                    $record->teacher_id = $teacher ? $teacher->id : null;
                })
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:50']),
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

    public function resolveRecord(): ?Extracurricular
    {
        $this->data = $this->normalizeData($this->data);

        // Get the academic year ID
        $academicYear = AcademicYear::where('year', $this->data['academic_year_id'])->first();
        $academicYearId = $academicYear ? $academicYear->id : null;

        // Get the teacher ID
        $employee = Employee::where('fullname', $this->data['teacher_id'])->first();
        $teacher = Teacher::where('employee_id', $employee ? $employee->id : null)->first();
        $teacherId = $teacher ? $teacher->id : null;

        // Find existing extracurricular by academic_year_id and name, or create new
        $extracurricular = Extracurricular::firstOrNew([
            'academic_year_id' => $academicYearId,
            'name' => $this->data['name'],
        ]);

        // Update the extracurricular attributes
        $extracurricular->fill([
            'academic_year_id' => $academicYearId,
            'teacher_id' => $teacherId,
            'name' => $this->data['name'],
        ]);

        // Save the extracurricular record
        $extracurricular->save();

        return $extracurricular;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your extracurricular import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
