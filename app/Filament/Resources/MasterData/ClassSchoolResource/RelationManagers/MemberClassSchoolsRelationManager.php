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

    protected static ?string $recordTitleAttribute = 'student_id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('academic_year_id')
                    ->default(AcademicYear::where('status', 1)->first()->id),
                    MultiselectTwoSides::make('student_id')
                    ->options(
                        Student::doesntHave('classSchool')
                            ->with('classSchool')
                            ->get()
                            ->mapWithKeys(function ($student) {
                                $className = $student->classSchool->name ?? 'No Class';
                                return [$student->id => $student->fullname . ' - ' . $className];
                            })
                            ->toArray()
                    )
                    ->selectableLabel('Student does not have a class')
                    ->selectedLabel('Selected Student')
                    ->enableSearch(),
            ])->columns('full');
    }

    protected function afterSave($record): void
    {
        $studentIds = $this->form->getState()['student_id'];

        foreach ($studentIds as $studentId) {
            MemberClassSchool::create([
                'academic_year_id' => $record->academic_year_id,
                'student_id' => $studentId,
                'class_school_id' => $record->class_id,
            ]);
        }
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
