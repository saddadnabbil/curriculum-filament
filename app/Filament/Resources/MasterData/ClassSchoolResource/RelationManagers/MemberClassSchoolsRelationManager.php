<?php

namespace App\Filament\Resources\MasterData\ClassSchoolResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MasterData\Student;
use Filament\Forms\Components\Hidden;
use App\Models\MasterData\ClassSchool;
use App\Models\MasterData\AcademicYear;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MasterData\MemberClassSchool;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use LucasGiovanny\FilamentMultiselectTwoSides\Forms\Components\Fields\MultiselectTwoSides;

class MemberClassSchoolsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberClassSchools';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('academic_year_id')
                    ->default(AcademicYear::where('status', 1)->first()->id),
                Hidden::make('class_id'),
                MultiselectTwoSides::make('student_id')
                    ->options(
                        Student::doesntHave('classSchool')->pluck('fullname', 'id')->toArray()
                    )
                    ->selectableLabel('Student does not have a class')
                    ->selectedLabel('Selected Student')
                    ->enableSearch(),
            ])->columns('full');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('student_id')
            ->columns([
                Tables\Columns\TextColumn::make('student_id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
