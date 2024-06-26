<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\Grading;
use Filament\Resources\Resource;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use App\Models\ClassSchool;
use App\Models\LearningData;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanSumatifValue;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\PlanFormatifValue;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Models\MemberClassSchool;
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

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    protected static function calculateAverage($data, $record)
    {
        $formatif_techniques = ['formatif_technique_1', 'formatif_technique_2', 'formatif_technique_3'];

        $sumatif_techniques = ['sumatif_technique_1', 'sumatif_technique_2', 'sumatif_technique_3'];

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

        $formatif_weighted_sum = array_sum(
            array_map(
                function ($value, $weight) {
                    return $value * $weight;
                },
                $formatif_values,
                $formatif_weights,
            ),
        );

        $sumatif_weighted_sum = array_sum(
            array_map(
                function ($value, $weight) {
                    return $value * $weight;
                },
                $sumatif_values,
                $sumatif_weights,
            ),
        );

        $total_weights = array_sum($formatif_weights) + array_sum($sumatif_weights);

        return ($formatif_weighted_sum + $sumatif_weighted_sum) / $total_weights;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('planFormatifValue.learningData.subject.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('memberClassSchool.student.fullname')
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
                        ->tooltip(fn ($record): string => self::getTechniqueFormatif($record, 0)),
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
                        ->tooltip(fn ($record): string => self::getTechniqueFormatif($record, 1)),
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
                        ->tooltip(fn ($record): string => self::getTechniqueFormatif($record, 2)),
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
                        ->tooltip(fn ($record): string => self::getTechniqueSumatif($record, 0)),
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
                        ->tooltip(fn ($record): string => self::getTechniqueSumatif($record, 1)),
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
                        ->tooltip(fn ($record): string => self::getTechniqueSumatif($record, 2)),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('Report Value', [
                    TextInputColumn::make('nilai_akhir')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->disabled()
                        ->label('Final Grade'),
                    TextInputColumn::make('nilai_revisi')
                        ->alignment(Alignment::Center)
                        ->rules(['numeric', 'min:0', 'max:100'])
                        ->label('Revision Grade'),
                ])->alignment(Alignment::Center),
            ])
            ->filters(
                [
                    Tables\Filters\SelectFilter::make('learning_data_id')
                        ->label('Learning Data')
                        ->relationship('planFormatifValue.learningData', 'id', function ($query) {
                            if (auth()->user()->hasRole('super_admin')) {
                                return $query->with('subject')->whereHas('classSchool', function (Builder $query) {
                                    $query->where('academic_year_id', Helper::getActiveAcademicYearId());
                                });
                            } else {
                                $user = auth()->user();
                                if ($user && $user->employee && $user->employee->teacher) {
                                    $teacherId = $user->employee->teacher->id;
                                    return $query->with('subject')
                                        ->whereHas('classSchool', function (Builder $query) {
                                            $query->where('academic_year_id', Helper::getActiveAcademicYearId());
                                        })->where('teacher_id', $teacherId);
                                }
                                return $query->with('subject');
                            }
                        })
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->subject->name . ' - ' . $record->classSchool->name)
                        ->searchable()
                        ->preload()
                        ->default(function () {
                            // Fetch the first record based on the same query logic used in the relationship
                            $query = auth()->user()->hasRole('super_admin') ?
                                PlanFormatifValue::with(['learningData' => function ($query) {
                                    $query->with('subject')->first();
                                }])->first() :
                                PlanFormatifValue::whereHas('learningData', function (Builder $query) {
                                    $query->with('subject')
                                        ->whereHas('classSchool', function (Builder $query) {
                                            $query->where('academic_year_id', Helper::getActiveAcademicYearId());
                                        })
                                        ->where('teacher_id', auth()->user()->employee->teacher->id);
                                })->first();

                            return $query ? $query->learningData->id : null;
                        }),
                    Tables\Filters\SelectFilter::make('term_id')->label('Term')->options([
                        '1' => '1',
                        '2' => '2',
                    ])->searchable()->visible(fn () => Auth::user()->hasRole('super_admin'))->preload(),
                    Tables\Filters\SelectFilter::make('semester_id')->label('Semester')->relationship('semester', 'semester')->searchable()->visible(fn () => Auth::user()->hasRole('super_admin'))->preload(),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->deselectAllRecordsWhenFiltered(false)
            ->filtersFormColumns(3)
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery()->whereHas('memberClassSchool.classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            });
        } else {
            return parent::getEloquentQuery()->whereHas('memberClassSchool.classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            })->whereHas('memberClassSchool.classSchool.level.term', function (Builder $query) {
                $query->where('id', Helper::getActiveTermIdPrimarySchool());
            })->whereHas('memberClassSchool.classSchool.level.semester', function (Builder $query) {
                $query->where('id', Helper::getActiveSemesterIdPrimarySchool());
            })->whereHas('planFormatifValue.learningData.teacher', function (Builder $query) {
                $user = auth()->user();
                if ($user && $user->employee && $user->employee->teacher) {
                    $teacherId = $user->employee->teacher->id;
                    $query->where('teacher_id', $teacherId);
                }
            });
        }
    }

    public static function getRecord($key): Model
    {
        return static::getEloquentQuery()->findOrFail($key);
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
