<?php

namespace App\Filament\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('username')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('email_verified_at')
                ->rules(['nullable', 'date_format:Y-m-d H:i:s'])
                ->fillRecordUsing(function (?User $record, string $state): void {
                    $record->email_verified_at = $state ? Carbon::createFromFormat('Y-m-d H:i:s', $state) : null;
                }),
            ImportColumn::make('status')
                ->boolean()
                ->requiredMapping()
                ->fillRecordUsing(function (?User $record, bool $state): void {
                    $record->status = $state;
                }),
        ];
    }

    protected function normalizeData(array $data): array
    {
        $normalizedData = [];
        foreach ($data as $key => $value) {
            $normalizedKey = strtolower(trim(str_replace(' ', '_', $key)));
            $normalizedData[$normalizedKey] = $value;
        }
        return $normalizedData;
    }

    public function resolveRecord(): ?User
    {
        $this->data = $this->normalizeData($this->data);

        // Create or update the user
        $user = User::firstOrNew([
            'username' => $this->data['username'],
            'email' => $this->data['email'],
        ]);

        // Update user attributes
        $user->password = bcrypt($this->data['username']);
        $user->email_verified_at = $this->data['email_verified_at'] ? Carbon::createFromFormat('Y-m-d H:i:s', $this->data['email_verified_at']) : null;
        $user->status = $this->data['status'];

        // Save the user to ensure it has an ID
        $user->save();

        // assign role
        if (isset($this->data['roles'])) {
            $roleNames = explode(',', $this->data['roles']);
            // remove whitespace
            $roleNames = array_map('trim', $roleNames);
            $user->assignRole($roleNames);
        }

        // Handle roles
        if (isset($this->data['roles'])) {
            $roleNames = explode(',', $this->data['roles']);
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $user->roles()->sync($roleIds);
        }

        return $user;
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
