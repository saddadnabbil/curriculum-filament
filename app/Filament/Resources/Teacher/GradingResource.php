<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\Teacher\Grading;
use Filament\Resources\Resource;
use App\Models\MasterData\Student;
use App\Models\MasterData\Subject;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use App\Models\MasterData\ClassSchool;
use App\Models\MasterData\LearningData;
use Filament\Tables\Columns\TextColumn;
use App\Models\Teacher\PlanSumatifValue;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Teacher\PlanFormatifValue;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Models\MasterData\MemberClassSchool;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\GradingResource\Pages;
use App\Filament\Resources\Teacher\GradingResource\RelationManagers;

class GradingResource extends Resource
{
    protected static ?string $model = Grading::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'grading';

    protected function getHeaderActions(): array
    {
        return [
                //     Action::make('Single Class')
                //         ->form([
                //             Select::make('plan_formatif_value_id')
                //                 ->relationship('planFormatifValue', 'id', function ($query) {
                //                     return $query->with('learningData');
                //                 })
                //                 ->getOptionLabelFromRecordUsing(fn($record) => $record->learningData->subject->name . ' - ' . $record->learningData->classSchool->name)
                //                 ->required()
                //                 ->searchable()
                //                 ->preload()
                //                 ->live()
                //                 ->afterStateUpdated(function ($state, callable $set, $get) {
                //                     $planFormatifValue = PlanFormatifValue::find($state);
                //                     if ($planFormatifValue) {
                //                         $learningData = LearningData::with('classSchool.level.semester')->find($planFormatifValue->learning_data_id);
                //                         $semesterId = $learningData ? $learningData->classSchool->level->semester->id : null;
                //                         $planSumatifValue = PlanSumatifValue::where('learning_data_id', $learningData->id)
                //                             ->where('semester_id', $semesterId)
                //                             ->first();
                //                         $set('plan_sumatif_value_id', $planSumatifValue->id);
                //                     }
                //                 }),
                //             Hidden::make('plan_sumatif_value_id'),
                //             CheckboxList::make('member_class_schools')
                //                 ->label('Students')
                //                 ->options(function (Get $get) {
                //                     $selectedPlanFormatifValue = PlanFormatifValue::find($get('plan_formatif_value_id'));
                //                     if ($selectedPlanFormatifValue) {
                //                         $learningData = LearningData::with(['classSchool', 'subject'])
                //                             ->where('id', $selectedPlanFormatifValue->learning_data_id)
                //                             ->first();
                //                         if ($learningData) {
                //                             $classSchool = ClassSchool::query()
                //                                 ->where('id', $learningData->class_school_id)
                //                                 ->first();
                //                             $memberClassSchool = MemberClassSchool::query()
                //                                 ->where('class_school_id', $classSchool->id)
                //                                 ->where('academic_year_id', $classSchool->academic_year_id)
                //                                 ->get()
                //                                 ->pluck('student_id')
                //                                 ->toArray();
                //                             return Student::whereIn('id', $memberClassSchool)->get()->pluck('fullname', 'id');
                //                         }
                //                     }
                //                 })
                //                 ->searchable()
                //                 ->bulkToggleable()
                //                 ->columns(3),
                //         ])
                //         ->icon('heroicon-o-pencil')
                //         ->action(function (array $data): void {
                //             $dataArray = [];
                //             $getCLassroomStudentIds = $data['student_id'];
                //             if (!count($getCLassroomStudentIds)) {
                //                 Notification::make()->warning()->title('Whopps, cant do that :(')->body('No student selected')->send();
                //             } else {
                //                 for ($i = 0; $i < count($getCLassroomStudentIds); $i++) {
                //                     $dataArray[] = [
                //                         'student_id' => $getCLassroomStudentIds[$i],
                //                         'assessment_method_setting_id' => $data['assessment_method_setting_id'],
                //                         'topic_setting_id' => $data['topic_setting_id'],
                //                         'subject_user_id' => $data['subject_user_id'],
                //                         'topic_name' => $data['topic_name'],
                //                     ];
                //                 }
                //                 if (DB::table('assessments')->insertOrIgnore($dataArray)) {
                //                     Notification::make()->success()->title('yeayy, success!')->body('Successfully added data')->send();
                //                 }
                //             }
                //         }),
            ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    // protected static function calculateAverage($data)
    // {
    //     $formatif_1 = (float) ($data['formatif_technique_1'] ?? 0);
    //     $formatif_2 = (float) ($data['formatif_technique_2'] ?? 0);
    //     $formatif_3 = (float) ($data['formatif_technique_3'] ?? 0);
    //     $sumatif_1 = (float) ($data['sumatif_technique_1'] ?? 0);
    //     $sumatif_2 = (float) ($data['sumatif_technique_2'] ?? 0);
    //     $sumatif_3 = (float) ($data['sumatif_technique_3'] ?? 0);

    //     return ($formatif_1 + $formatif_2 + $formatif_3 + $sumatif_1 + $sumatif_2 + $sumatif_3) / 6;
    // }

    protected static function calculateAverage($data, $record)
    {
        $formatif_techniques = [
            'formatif_technique_1',
            'formatif_technique_2',
            'formatif_technique_3',
        ];

        $sumatif_techniques = [
            'sumatif_technique_1',
            'sumatif_technique_2',
            'sumatif_technique_3',
        ];

        $formatif_values = array_map(function ($technique) use ($data) {
            return (float) ($data[$technique] ?? 0);
        }, $formatif_techniques);

        $sumatif_values = array_map(function ($technique) use ($data) {
            return (float) ($data[$technique] ?? 0);
        }, $sumatif_techniques);

        $formatif_weights = array_map(function ($index) use ($record) {
            return (float) ($record->planFormatifValue->techniques[$index]->weighting ?? 1);
        }, array_keys($formatif_techniques));

        $sumatif_weights = array_map(function ($index) use ($record) {
            return (float) ($record->planSumatifValue->techniques[$index]->weighting ?? 1);
        }, array_keys($sumatif_techniques));

        $formatif_weighted_sum = array_sum(array_map(function ($value, $weight) {
            return $value * $weight;
        }, $formatif_values, $formatif_weights));

        $sumatif_weighted_sum = array_sum(array_map(function ($value, $weight) {
            return $value * $weight;
        }, $sumatif_values, $sumatif_weights));

        $total_weights = array_sum($formatif_weights) + array_sum($sumatif_weights);

        return ($formatif_weighted_sum + $sumatif_weighted_sum) / $total_weights;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('memberClassSchool.student.fullname')
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                ColumnGroup::make('Formatif Value', [
                    TextInputColumn::make('formatif_technique_1')
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->alignment(Alignment::Center)
                        ->label('F1')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueFormatif($record, 0)),
                    TextInputColumn::make('formatif_technique_2')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('F2')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueFormatif($record, 1)),
                    TextInputColumn::make('formatif_technique_3')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('F2')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueFormatif($record, 2)),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('Sumatif Value', [
                    TextInputColumn::make('sumatif_technique_1')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('S1')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueSumatif($record, 0)),
                    TextInputColumn::make('sumatif_technique_2')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('S2')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueSumatif($record, 1)),
                    TextInputColumn::make('sumatif_technique_3')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('S2')
                        ->afterStateUpdated(function ($record, $state) {
                            $data = $record->only(['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3', 'sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3']);
                            $average = self::calculateAverage($data, $record);
                            $record->nilai_akhir = $average;
                            $record->save();
                        })
                        ->tooltip(fn($record): string => self::getTechniqueSumatif($record, 2)),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('Report Value', [
                    TextInputColumn::make('nilai_akhir')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->disabled()
                        ->label('Akhir'),
                    TextInputColumn::make('nilai_revisi')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('Revisi'),
                ])->alignment(Alignment::Center),
            ])
            ->filters(
                [
                    Tables\Filters\SelectFilter::make('learning_data_id')
                        ->label('Learning Data')
                        ->relationship('planFormatifValue.learningData', 'id', function ($query) {
                            if (auth()->user()->hasRole('super_admin')) {
                                return $query->with('subject');
                            } else {
                                $user = auth()->user();
                                if ($user && $user->employee && $user->employee->teacher) {
                                    $teacherId = $user->employee->teacher->id;
                                    return $query->with('subject')->where('teacher_id', $teacherId);
                                }
                                return $query->with('subject');
                            }
                        })
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->subject->name . ' - ' . $record->classSchool->name)
                        ->searchable()
                        ->preload(),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->filtersFormColumns(1)
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function getTechniqueFormatif($record, $index)
    {
        $techniques = $record->planFormatifValue->techniques ?? [];
        $techniqueCode = $techniques[$index]->code;
        $techniqueName = Helper::getPlanFormatifTechnique($techniques[$index]->technique);
        $techniqueKKM = $techniques[$index]->weighting;
        return isset($techniques[$index]) ? 'Code: ' . e($techniqueCode) . ', Technique: ' . e($techniqueName) . ', KKM: ' . e($techniqueKKM) : 'No technique available';
    }

    protected static function getTechniqueSumatif($record, $index)
    {
        $techniques = $record->planSumatifValue->techniques ?? [];
        $techniqueCode = $techniques[$index]->code;
        $techniqueName = Helper::getPlanSumatifTechnique($techniques[$index]->technique);
        $techniqueKKM = $techniques[$index]->weighting;
        return isset($techniques[$index]) ? 'Code: ' . e($techniqueCode) . ', Technique: ' . e($techniqueName) . ', KKM: ' . e($techniqueKKM) : 'No technique available';
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('menu.nav_group.report_km');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGradings::route('/'),
            // 'create' => Pages\CreateGrading::route('/create'),
            // 'edit' => Pages\EditGrading::route('/{record}/edit'),
        ];
    }
}
