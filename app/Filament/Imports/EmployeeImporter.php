<?php

namespace App\Filament\Imports;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Employee;
use App\Models\EmployeeUnit;
use App\Models\EmployeeStatus;
use App\Models\EmployeePosition;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\ValidationException;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user_id')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    // Ambil email dari input yang sesuai dengan username
                    $email = request()->input('email');
                    // Buat user baru atau ambil yang sudah ada berdasarkan username
                    $user = User::firstOrCreate(
                        ['username' => $state],
                        [
                            'email' => $email,
                            'password' => bcrypt('defaultpassword'), // Anda mungkin ingin menghasilkan password yang aman di sini
                            'status' => true,
                        ]
                    );

                    // Pastikan user memiliki ID
                    if (!isset($user->id)) {
                        throw ValidationException::withMessages(['user_id' => 'Failed to create or retrieve user.']);
                    }

                    // Set user_id pada record employee
                    $record->user_id = $user->id;
                }),
            ImportColumn::make('email')
                ->rules(['required', 'email']),
            ImportColumn::make('employee_status_id')
                ->label('Employee Status')
                // ->relationship('employeeStatus', 'name')  // Adjust the field name if necessary
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->employee_status_id = EmployeeStatus::where('name', $state)->value('id');
                })
                ->rules(['required']),
            ImportColumn::make('employee_unit_id')
                ->label('Employee Unit')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->employee_unit_id = EmployeeUnit::where('name', $state)->value('id');
                })
                ->rules(['required']),
            ImportColumn::make('employee_position_id')
                ->label('Employee Position')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->employee_position_id = EmployeePosition::where('name', $state)->value('id');
                })
                ->rules(['required']),
            ImportColumn::make('join_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('resign_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('permanent_date')
                ->rules(['nullable', 'date']),
            ImportColumn::make('fullname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('employee_code')
                ->requiredMapping()
                ->rules(['required', 'max:25']),
            ImportColumn::make('nik')
                ->rules(['max:16']),
            ImportColumn::make('number_account')
                ->rules(['max:255']),
            ImportColumn::make('number_fingerprint')
                ->rules(['max:255']),
            ImportColumn::make('number_npwp')
                ->rules(['max:255']),
            ImportColumn::make('name_npwp')
                ->rules(['max:255']),
            ImportColumn::make('number_bpjs_ketenagakerjaan')
                ->rules(['max:255']),
            ImportColumn::make('iuran_bpjs_ketenagakerjaan')
                ->rules(['max:255']),
            ImportColumn::make('number_bpjs_yayasan')
                ->rules(['max:255']),
            ImportColumn::make('number_bpjs_pribadi')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->gender = Helper::getSexByName($state ?? null);
                }),
            ImportColumn::make('religion')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->religion = Helper::getReligionByName($state ?? null);
                }),
            ImportColumn::make('place_of_birth')
                ->rules(['max:50']),
            ImportColumn::make('date_of_birth')
                ->rules(['date']),
            ImportColumn::make('address')
                ->rules(['max:255']),
            ImportColumn::make('address_now')
                ->rules(['max:255']),
            ImportColumn::make('city')
                ->rules(['max:255']),
            ImportColumn::make('postal_code')
                ->rules(['max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('email_school')
                ->rules(['email', 'max:255']),
            ImportColumn::make('citizen')
                ->rules(['max:255']),
            ImportColumn::make('marital_status')
                ->fillRecordUsing(function (Employee $record, string $state): void {
                    $record->marital_status = Helper::getMaritalStatusByName($state ?? null);
                }),
            ImportColumn::make('partner_name')
                ->rules(['max:255']),
            ImportColumn::make('number_of_childern')
                ->rules(['max:255']),
            ImportColumn::make('notes')
                ->rules(['max:255']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
