<?php

namespace App\Filament\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            // ImportColumn::make('id')
            //     ->requiredMapping()
            //     ->fillRecordUsing(function (User $record, string $state): void {
            //         $record->id = $state ?: Str::uuid()->toString();
            //     })
            //     ->rules(['required', 'uuid']),
            // ImportColumn::make('username')
            //     ->requiredMapping()
            //     ->rules(['required', 'max:255'])
            //     ->fillRecordUsing(function (User $record, string $state): void {
            //         $record->username = $state;
            //         $record->password = bcrypt($state); // Encrypt the password
            //     }),
            // ImportColumn::make('email')
            //     ->rules(['email', 'max:255']),
            // ImportColumn::make('email_verified_at')
            //     ->rules(['nullable', 'date_format:Y-m-d H:i:s']), // Use date_format rule
            // ImportColumn::make('status')
            //     ->boolean() // Casts the state to a boolean
            //     ->requiredMapping(),
            ImportColumn::make('id')
                ->requiredMapping()
                ->fillRecordUsing(function (User $record, string $state): void {
                    $record->id = $state ?: Str::uuid()->toString();
                })
                ->rules(['required', 'uuid']),
            ImportColumn::make('username')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->fillRecordUsing(function (User $record, string $state): void {
                    $record->username = $state;
                    $record->password = bcrypt($state); // Encrypt the password
                }),
            ImportColumn::make('email')
                ->rules(['email', 'max:255'])
                ->fillRecordUsing(function (User $record, string $state): void {
                    $record->email = $state;
                }),
            ImportColumn::make('email_verified_at')
                ->rules(['nullable', 'date_format:Y-m-d H:i:s'])
                ->fillRecordUsing(function (User $record, string $state): void {
                    $record->email_verified_at = $state ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $state) : null;
                }),
            ImportColumn::make('status')
                ->boolean()
                ->requiredMapping()
                ->fillRecordUsing(function (User $record, bool $state): void {
                    $record->status = $state;
                }),
        ];
    }

    protected function beforeSave(User $record): void
    {
        // This method will be called before saving the record
        $record->save();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
