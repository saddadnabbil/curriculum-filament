<?php

namespace App\Filament\Resources\MasterData\StudentResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MasterData\StudentResource;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $date_of_birth = $this->data['date_of_birth'];
        $timestamp = strtotime($date_of_birth);
        $password = date('dmY', $timestamp);
        $password = Hash::make($password);

        dd($this->data);
        $user = User::create([
            'username' => $this->data['nis'],
            'email' => $this->data['email'],
            'password' => $password,
            'status' => 1,
        ]);
        $user->assignRole('student');


        $this->data['user_id'] = $user->id;

        return $data;
    }
}
