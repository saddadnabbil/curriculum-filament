<?php

namespace App\Filament\Resources\Teacher\StudentDataResource\Pages;

use Filament\Actions;
use App\Helpers\Helper;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Teacher\StudentDataResource;

class ListStudentData extends ListRecords
{
    protected static string $resource = StudentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): ?string
    {
        $activeYear = 'School Year: ' . Helper::getActiveAcademicYearName();
        return $activeYear;
    }
}
