<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EmployeeResource;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $date_of_birth = $data['date_of_birth'];
        $timestamp = strtotime($date_of_birth);
        $password = date('dmY', $timestamp);
        $password = Hash::make($password);

        $user = User::create([
            'username' => $data['employee_code'],
            'email' => $data['email'],
            'password' => $password,
            'status' => 1,
        ]);

        $data['user_id'] = $user->id;

        return $data;
    }
}
