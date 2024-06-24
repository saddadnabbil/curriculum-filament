<?php

namespace App\Filament\Resources\Teacher;

use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Teacher\Grading;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Teacher\PlanFormatifValue;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Teacher\StudentDescriptionResource\Pages;

class StudentDescriptionResource extends Resource
{
    protected static ?string $model = Grading::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Student Description';

    protected static ?string $slug = 'student-description';

    protected static ?string $modelLabel = 'Student Description';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('member_class_school_name')
                    ->label('Student Full Name')
                    ->readOnly()
                    ->formatStateUsing(function ($state, $record) {
                        return $record->memberClassSchool->student->fullname ?? '';
                    }),

                TextInput::make('member_class_school_id')
                    ->label('Member Class School ID')
                    ->hidden()
                    ->default(fn ($record) => $record->memberClassSchool->id ?? null),

                Textarea::make('description')
                    ->helperText('Maximum input length is 200 characters.')
                    ->minLength(0)
                    ->maxLength(200),
            ])->columns('full');
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
                ColumnGroup::make('Grading', [
                    TextColumn::make('nilai_akhir')
                        ->alignment(Alignment::Center)
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('nilai_revisi')
                        ->alignment(Alignment::Center)
                        ->searchable()
                        ->sortable(),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('Learning Outcome', [
                    TextColumn::make('description')
                        ->alignment(Alignment::Center)
                        ->label('Description')
                        ->limit(100)
                        ->columnSpan('full'),
                ])->alignment(Alignment::Center),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('learning_data_id')
                    ->label('Learning Data')
                    ->relationship('planFormatifValue.learningData', 'id', function ($query) {
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
            ], layout: FiltersLayout::AboveContent)
            ->deselectAllRecordsWhenFiltered(false)
            ->filtersFormColumns(3)
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
        return __("menu.nav_group.report_km");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentDescriptions::route('/'),
            // 'create' => Pages\CreateStudentDescription::route('/create'),
            // 'edit' => Pages\EditStudentDescription::route('/{record}/edit'),
        ];
    }
}
