<?php

namespace App\Filament\Resources\SuperAdmin\EmployeeResource\Pages;

use App\Models\User;
use Exception;
use Filament\Actions;
use App\Settings\MailSettings;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SuperAdmin\EmployeeResource;
use Filament\Notifications\Auth\VerifyEmail;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
