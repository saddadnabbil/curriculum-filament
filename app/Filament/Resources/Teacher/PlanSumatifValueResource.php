<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use App\Models\MasterData\LearningData;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher\PlanSumatifValue;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\PlanSumatifValueResource\Pages;
use App\Filament\Resources\Teacher\PlanSumatifValueResource\RelationManagers;

class PlanSumatifValueResource extends Resource
{
    protected static ?string $model = PlanSumatifValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'plan-sumatif-values';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('learning_data_id')
                    ->relationship('learningData', 'id', function ($query) {
                        if (auth()->user()->hasRole('super_admin')) {
                            return $query->with('subject');
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
                    ->required()
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $learningData = LearningData::with('classSchool.level.semester')->find($state);
                        $semesterId = $learningData ? $learningData->classSchool->level->semester->id : null;
                        $termId = $learningData ? $learningData->classSchool->level->term->id : null;
                        $set('semester_id', $semesterId);
                        $set('term_id', $termId);
                    })
                    ->rules(function ($get) {
                        $recordId = $get('learning_data_id'); // Assuming 'recordId' is available in the context
                        return [
                            Rule::unique('plan_sumatif_values', 'learning_data_id')->ignore($recordId)
                        ];
                    })
                    ->columnspan('full'),
                Hidden::make('semester_id'),
                Hidden::make('term_id'),
                Repeater::make('techniques')
                    ->relationship('techniques')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        Select::make('technique')
                            ->options([
                                '1' => 'Tes Tulis',
                                '2' => 'Tes Lisan',
                                '3' => 'Penugasan',
                            ])
                            ->required(),
                        TextInput::make('weighting')
                            ->required()
                            ->numeric()
                            ->helperText('Enter a value between 0 and 100')
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->minItems(3)
                    ->maxItems(3)
                    ->addActionLabel('Add Assessment Technique')
                    ->columns(3)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('learningData.subject.name')
                    ->label('Learning Data')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('learningData.classSchool.name')
                    ->label('Class School')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('learning_data_id')
                    ->label('Learning Data')
                    ->relationship('learningData', 'id', function ($query) {
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
                    ->default(function () {
                        // Fetch the first record based on the same query logic used in the relationship
                        $query = auth()->user()->hasRole('super_admin') ?
                        PlanSumatifValue::with(['learningData' => function ($query) {
                            $query->with('subject')->first();
                        }])->first() :
                        PlanSumatifValue::whereHas('learningData', function (Builder $query) {
                            $query->with('subject')
                                ->whereHas('classSchool', function (Builder $query) {
                                    $query->where('academic_year_id', Helper::getActiveAcademicYearId());
                                })
                                ->where('teacher_id', auth()->user()->employee->teacher->id);
                        })->first();

                        return $query ? $query->learningData->id : null;
                    })
                    ->searchable()
                    ->preload()
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(1)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery()->whereHas('learningData.classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            });
        } else {
            return parent::getEloquentQuery()->whereHas('learningData.classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            })->whereHas('learningData.classSchool.level.term', function (Builder $query) {
                $query->where('id', Helper::getActiveTermIdPrimarySchool());
            })->whereHas('learningData.classSchool.level.semester', function (Builder $query) {
                $query->where('id', Helper::getActiveSemesterIdPrimarySchool());
            })->whereHas('learningData.teacher', function (Builder $query) {
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
        return __("menu.nav_group.report_km");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanSumatifValues::route('/'),
            'create' => Pages\CreatePlanSumatifValue::route('/create'),
            'edit' => Pages\EditPlanSumatifValue::route('/{record}/edit'),
        ];
    }
}
