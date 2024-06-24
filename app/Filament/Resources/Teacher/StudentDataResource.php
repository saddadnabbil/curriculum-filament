<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentData;
use Filament\Resources\Resource;
use App\Models\MasterData\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\StudentDataResource\Pages;
use App\Filament\Resources\Teacher\StudentDataResource\RelationManagers;

class StudentDataResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = -1;

    protected static ?string $slug = 'student-data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([Tables\Columns\TextColumn::make('fullname')->searchable(), Tables\Columns\TextColumn::make('classSchool.name')->numeric()->sortable(), Tables\Columns\TextColumn::make('level.name')->numeric()->sortable(), Tables\Columns\TextColumn::make('line.name')->numeric()->sortable(), Tables\Columns\TextColumn::make('nis')->label('NIS')->searchable(), Tables\Columns\TextColumn::make('nisn')->label('NISN')->searchable(), Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), Tables\Columns\TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery()->whereHas('classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());});
        } else {
            return parent::getEloquentQuery()->whereHas('classSchool.academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            })->whereHas('classSchool.level.term', function (Builder $query) {
                $query->where('id', Helper::getActiveTermIdPrimarySchool());
            })->whereHas('classSchool.level.semester', function (Builder $query) {
                $query->where('id', Helper::getActiveSemesterIdPrimarySchool());
            })->whereHas('classSchool.teacher', function (Builder $query) {
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
        return __("menu.nav_group.report_km_homeroom");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentData::route('/'),
            // 'create' => Pages\CreateStudentData::route('/create'),
            'view' => Pages\ViewStudentData::route('/{record}'),
            // 'edit' => Pages\EditStudentData::route('/{record}/edit'),
        ];
    }
}
