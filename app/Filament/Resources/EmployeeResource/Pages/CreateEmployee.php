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

    protected function beforeCreate(): void
    {
        $tanggal_lahir = $this->data['tanggal_lahir'];
        $timestamp = strtotime($tanggal_lahir);
        $password = date('dmY', $timestamp);
        $password = Hash::make($password);

        // nama_lengkap strloweer and remove space
        $user = User::create([
            'username' => $this->data['kode_karyawan'],
            'email' => $this->data['email'],
            'password' => $password,
            'status' => 1,
        ]);

        $this->data['user_id'] = $user->id;
    }
}
