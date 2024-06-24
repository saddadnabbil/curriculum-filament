<?php

namespace App\Filament\Resources\Teacher\StudentAttendanceResource\Pages;

use Filament\Actions;
use App\Helpers\Helper;
use Filament\Forms\Get;
use Filament\Actions\Action;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MasterData\Extracurricular;
use Filament\Forms\Components\CheckboxList;
use App\Models\MasterData\MemberClassSchool;
use App\Filament\Resources\Teacher\StudentAttendanceResource;
use App\Models\MasterData\ClassSchool;

class ListStudentAttendances extends ListRecords
{
    protected static string $resource = StudentAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Select Student')
                ->form([
                    Select::make('class_school_id')
                        ->relationship('classSchool', 'name', function ($query) {
                            return $query->whereNotIn('level_id', [1, 2, 3])->where('academic_year_id', Helper::getActiveAcademicYearId());
                        })
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                        ->required()
                        ->searchable()
                        ->preload()
                        ->label('Class School')
                        ->live(),
                    CheckboxList::make('member_class_school_id')
                        ->label('Students')
                        ->rules(function ($get) {
                            $classSchoolId = $get('class_school_id');

                            return [
                                Rule::unique('student_attendances', 'member_class_school_id')->where(function ($query) use ($classSchoolId) {
                                    return $query->where('class_school_id', $classSchoolId);
                                }),
                            ];
                        })
                        ->options(function (Get $get) {
                            $selectedClassSchool = ClassSchool::find($get('class_school_id'));

                            if ($selectedClassSchool) {
                                if ($selectedClassSchool->memberClassSchools) {
                                    $memberClassSchool = $selectedClassSchool->memberClassSchools->pluck('id')
                                    ->toArray();

                                    return MemberClassSchool::whereIn('id', $memberClassSchool)->get()->pluck('student.fullname', 'id');
                                }
                            }

                            return collect(); // Return an empty collection if the checks fail
                        })
                        ->searchable()
                        ->bulkToggleable()
                        ->columns(3),
                ])
                ->action(function (array $data): void {
                    $dataArray = [];
                    $getMemberExtracurricularId = $data['member_extracurricular_id'];

                    if (!count($getMemberExtracurricularId)) {
                        Notification::make()->warning()->title('Whopps, cant do that :(')->body('No student selected')->send();
                    } else {
                        for ($i = 0; $i < count($getMemberExtracurricularId); $i++) {
                            $dataArray = [
                                'extracurricular_id' => $data['extracurricular_id'],
                                'member_extracurricular_id' => $getMemberExtracurricularId[$i],
                            ];

                            $exists = DB::table('member_extracurriculars')
                                ->where('id', $getMemberExtracurricularId[$i])
                                ->exists();

                            if (!$exists) {
                                Notification::make()
                                    ->warning()
                                    ->title('Warning')
                                    ->body('Member extracurricular ID ' . $getMemberExtracurricularId[$i] . ' does not exist.')
                                    ->send();

                                Log::warning('Member extracurricular ID does not exist', [
                                    'member_class_school_id' => $getMemberExtracurricularId[$i],
                                ]);

                                continue; 
                            }

                            try {
                                DB::table('extracurricular_assessments')->insert($dataArray);

                                // Send success notification
                                Notification::make()->success()->title('Yeayy, success!')->body('Successfully added data')->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->danger()
                                    ->title('Error')
                                    ->body('An error occurred: ' . $e->getMessage())
                                    ->send();

                                // Log the error for debugging
                                Log::error('Error inserting extracurricular_assessments: ' . $e->getMessage(), [
                                    'dataArray' => $dataArray,
                                ]);
                            }
                        }
                    }
                }),
        ];
    }
}
