<?php

namespace App\Filament\Resources\Teacher\StudentAttendanceResource\Pages;

use App\Filament\Resources\Teacher\StudentAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentAttendance extends CreateRecord
{
    protected static string $resource = StudentAttendanceResource::class;
}
