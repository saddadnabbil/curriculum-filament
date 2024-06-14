<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Models\User;
use Exception;
use Filament\Actions;
use App\Settings\MailSettings;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EmployeeResource;
use Filament\Notifications\Auth\VerifyEmail;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $date_of_birth = $data['date_of_birth'];
        $timestamp = strtotime($date_of_birth);
        $password = date('dmY', $timestamp);
        $password = Hash::make($password);

        // validate for unique employee code in username user
        $user = User::where('username', $data['employee_code'])->first();
        $email = User::where('email', $data['email'])->first();
        if (!is_null($user)) {
            Notification::make()
                ->title('Please use another email, email already in use')
                ->danger()
                ->send();
            return $data;
        } elseif (!is_null($email)) {
            Notification::make()
                ->title('Please use another email, email already in use')
                ->danger()
                ->send();
            return $data;
        }

        $user = User::create([
            'username' => $data['employee_code'],
            'email' => $data['email'],
            'password' => $password,
            'status' => 1,
        ]);
        $data['user_id'] = $user->id;

        if (!method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = new VerifyEmail();
        $notification->url = Filament::getVerifyEmailUrl($user);

        $settings = app(MailSettings::class);
        $settings->loadMailSettingsToConfig();

        $user->notify($notification);

        Notification::make()
            ->title(__('resource.user.notifications.notification_resent.title'))
            ->success()
            ->send();


        return $data;
    }
}
