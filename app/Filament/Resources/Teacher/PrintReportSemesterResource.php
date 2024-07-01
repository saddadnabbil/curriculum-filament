<?php

namespace App\Filament\Resources\Teacher;

use Filament\Tables;
use App\Helpers\Helper;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Tables\Table;
use App\Models\ClassSchool;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Teacher\PrintReportSemesterResource\Pages;

class PrintReportSemesterResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Print Semester Report';

    protected static ?string $modelLabel = 'Print Semester Report';

    protected static ?string $slug = 'print-report/semesters';

    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis'),
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('classSchool.name'),
            ])
            ->filters([
                SelectFilter::make('class_school_id')
                    ->label('Class School')
                    ->relationship('classSchool', 'name', function (Builder $query) {
                        if (auth()->user()->hasRole('super_admin')) {
                            return $query->whereNotIn('level_id', [1, 2, 3])
                                ->where('academic_year_id', Helper::getActiveAcademicYearId());
                        } else {
                            $user = auth()->user();
                            if ($user && $user->employee && $user->employee->teacher) {
                                $teacherId = $user->employee->teacher->id;
                                return $query->whereNotIn('level_id', [1, 2, 3])
                                    ->where('teacher_id', $teacherId)
                                    ->where('academic_year_id', Helper::getActiveAcademicYearId());
                            }
                            return $query->whereNotIn('level_id', [1, 2, 3])
                                ->where('academic_year_id', Helper::getActiveAcademicYearId());
                        }
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->searchable()
                    ->placeholder('Select a Class School')
                    ->preload(),
                // ->default(function () {
                //     $user = auth()->user();
                //     $teacherId = $user->employee->teacher->id;

                //     // Fetch the first record based on the same query logic used in the relationship
                //     $query = auth()->user()->hasRole('super_admin') ? ClassSchool::whereNotIn('level_id', [1, 2, 3])->where('academic_year_id', Helper::getActiveAcademicYearId())->first() : ClassSchool::whereNotIn('level_id', [1, 2, 3])->where('teacher_id', $teacherId)->where('academic_year_id', Helper::getActiveAcademicYearId())->first();

                //     return $query ? $query->id : null;
                // }),
                // Add term_id and semester_id filters but do not apply them to the query
                // SelectFilter::make('term_id')
                //     ->label('Term')
                //     ->searchable()
                //     ->preload()
                //     ->placeholder('Select Term')
                //     ->default(function (Get $get) {
                //         return ClassSchool::where('id', $get('class_school_id'))->classSchool->level->term_id;
                //     })->options([]),
                // SelectFilter::make('semester_id')
                //     ->label('Semester')
                //     ->searchable()
                //     ->preload()
                //     ->placeholder('Select Semester')
                //     ->options([
                //         '1' => '1',
                //         '2' => '2',
                //     ]),
            ], layout: FiltersLayout::AboveContent)
            ->deselectAllRecordsWhenFiltered(false)
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->action(function ($record, $data) {
                        $classSchoolId = Request::input('tableFilters.class_school_id.value');
                        $termId = Request::input('tableFilters.term_id.value');
                        $semesterId = Request::input('tableFilters.semester_id.value');

                        return redirect()->route('preview-pancasila-raport', [
                            'student_id' => $record->id,
                            'term_id' => $termId,
                            'semester_id' => $semesterId,
                            'class_school_id' => $classSchoolId
                        ]);
                    })
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
        // ->modifyQueryUsing(function (Builder $query): Builder {
        //     // Get the filter value from the request
        //     $classSchoolId = Request::input('tableFilters.class_school_id.value') ?? null;

        //     if ($classSchoolId) {
        //         $query->where('class_school_id', $classSchoolId);
        //     } else {
        //         // Force the user to select a filter
        //         $query->whereRaw('1 = 0'); // No results until filter is applied
        //     }

        //     return $query;
        // });
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     $query = parent::getEloquentQuery();

    //     // Ensure the filter is always applied
    //     $classSchoolId = Request::input('tableFilters.class_school_id.value') ?? null;

    //     if ($classSchoolId) {
    //         $query->where('class_school_id', $classSchoolId);
    //     } else {
    //         // Force the user to select a filter
    //         $query->whereRaw('1 = 0'); // No results until filter is applied
    //     }

    //     return $query;
    // }

    // public static function getRecord($key): Model
    // {
    //     return static::getEloquentQuery()->findOrFail($key);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrintReportSemesters::route('/'),
            // 'create' => Pages\CreatePrintReportSemester::route('/create'),
            // 'edit' => Pages\EditPrintReportSemester::route('/{record}/edit'),
        ];
    }
}
