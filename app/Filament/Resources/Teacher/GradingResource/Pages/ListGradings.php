<?php

namespace App\Filament\Resources\Teacher\GradingResource\Pages;

use Filament\Actions;
use Filament\Forms\Get;
use Filament\Actions\Action;
use App\Models\MasterData\Student;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use App\Models\MasterData\ClassSchool;
use App\Models\MasterData\LearningData;
use App\Models\Teacher\PlanSumatifValue;
use Filament\Notifications\Notification;
use App\Models\Teacher\PlanFormatifValue;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\CheckboxList;
use App\Models\MasterData\MemberClassSchool;
use App\Filament\Resources\Teacher\GradingResource;

class ListGradings extends ListRecords
{
    protected static string $resource = GradingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Select Student')
                ->form([
                    Select::make('plan_formatif_value_id')
                        ->relationship('planFormatifValue', 'id', function ($query) {
                            return $query->with('learningData');
                        })
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->learningData->subject->name . ' - ' . $record->learningData->classSchool->name)
                        ->required()
                        ->searchable()
                        ->preload()
                        ->label('Learning Data')
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $planFormatifValue = PlanFormatifValue::find($state);
                            if($planFormatifValue){
                                $user = auth()->user();
                                if ($user->hasRole('super_admin')){
                                    $learningData = LearningData::with('classSchool.level.semester')->find($planFormatifValue->learning_data_id);
                                } else {
                                    if ($user && $user->employee && $user->employee->teacher) {
                                        $learningData = LearningData::with('classSchool.level.semester')->where('teacher_id', $user->employee->teacher->id)->find($planFormatifValue->learning_data_id);
                                    }
                                }
                                $semesterId = $learningData ? $learningData->classSchool->level->semester->id : null;
                                
                                $planSumatifValue = PlanSumatifValue::where('learning_data_id', $learningData->id)->where('semester_id', $semesterId)->first();

                                if($planSumatifValue){
                                    $set('plan_sumatif_value_id', $planSumatifValue->id);
                                }

                            }
                        }),
                    Hidden::make('plan_sumatif_value_id'),
                    CheckboxList::make('member_class_school_id')
                    ->label('Students')
                    ->unique()
                    ->options(function(Get $get){
                        $selectedPlanFormatifValue = PlanFormatifValue::find($get('plan_formatif_value_id'));
                        if($selectedPlanFormatifValue) {
                            $learningData = LearningData::with(['classSchool', 'subject'])->where('id',$selectedPlanFormatifValue->learning_data_id)->first();
                            
                            if($learningData){
                                
                                $classSchool = ClassSchool::query()
                                ->where('id', $learningData->class_school_id)->first();

                                $slugSubject = $learningData->subject->slug;

                                $subjectFirstWord = explode('-', $slugSubject)[0];
                    
                                $religion = null;
                    
                                if (strtolower($subjectFirstWord) === 'religion') {
                                    $slug = explode('-', $slugSubject);
                                    if (count($slug) > 1) {
                                        $slugReligion = strtolower($slug[1]);
                    
                                        switch ($slugReligion) {
                                            case 'islam':
                                                $religion = 1;
                                                break;
                                            case 'protestan':
                                                $religion = 2;
                                                break;
                                            case 'katolik':
                                                $religion = 3;
                                                break;
                                            case 'hindu':
                                                $religion = 4;
                                                break;
                                            case 'budha':
                                                $religion = 5;
                                                break;
                                            case 'khonghucu':
                                                $religion = 6;
                                                break;
                                            case 'lainnya':
                                                $religion = 7;
                                                break;
                                            default:
                                                $religion = null;
                                                break;
                                        }
                                    }
                                }


                                $memberClassSchool = MemberClassSchool::query()
                                    ->where('class_school_id',$classSchool->id)
                                    ->where('academic_year_id',$classSchool->academic_year_id)
                                    ->whereHas('student', function ($query) use ($religion) {
                                        if($religion !== null){
                                            $query->where('religion', $religion);
                                        }
                                    })
                                    ->get()
                                    ->pluck('student_id')
                                    ->toArray();

                                return Student::whereIn('id', $memberClassSchool)->get()->pluck('fullname','id');
                            }
                        }
                        
                    })
                    // ->default(fn (CheckboxList $component): array => dd($component))
                    ->searchable()
                    ->bulkToggleable()
                    ->columns(3),
                ])
                ->action(function (array $data): void {
                    $dataArray = [];
                    $getMemberClassSchoolId = $data['member_class_school_id'];

                    if(!count($getMemberClassSchoolId)){
                        Notification::make()
                            ->warning()
                            ->title('Whopps, cant do that :(')
                            ->body("No student selected")
                            ->send();
                    } else if($data['plan_sumatif_value_id'] == null){
                        Notification::make()
                            ->warning()
                            ->title('Whopps, cant do that :(')
                            ->body("No have plan sumatif selected")
                            ->send();
                    } else if($data['plan_formatif_value_id'] == null) { 
                        Notification::make()
                        ->warning()
                        ->title('Whopps, cant do that :(')
                        ->body("No have plan formatif selected")
                        ->send();
                    } else {
                        for($i=0; $i < count($getMemberClassSchoolId); $i++) {
                            $dataArray[] = [
                                'member_class_school_id' => $getMemberClassSchoolId[$i],
                                'plan_formatif_value_id' => $data['plan_formatif_value_id'],
                                'plan_sumatif_value_id' => $data['plan_sumatif_value_id'],
                            ];
                        }
        
                        if(DB::table('gradings')->insertOrIgnore($dataArray)){
                            Notification::make()
                                ->success()
                                ->title('yeayy, success!')
                                ->body('Successfully added data')
                                ->send();
                        }
                    }
    
                })
        ];
    }
}
