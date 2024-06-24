<?php

namespace App\Filament\Resources\MasterData\ExtracurricularResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MasterData\Student;
use Filament\Forms\Components\Select;
use App\Models\MasterData\AcademicYear;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MasterData\MemberClassSchool;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use LucasGiovanny\FilamentMultiselectTwoSides\Forms\Components\Fields\MultiselectTwoSides;

class MemberExtracurricularRelationManager extends RelationManager
{
    protected static string $relationship = 'memberExtracurricular';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('academic_year_id')->default(AcademicYear::where('status', 1)->first()->id),
                MultiSelectTwoSides::make('member_class_school_id')
                    ->options(
                        MemberClassSchool::doesntHave('extracurricular')
                            ->with('extracurricular')
                            ->get()
                            ->mapWithKeys(function ($memberClass) {
                                $className = $memberClass->classSchool->name ?? 'No Class';
                                return [$memberClass->student->id => $memberClass->student->nis . ' - ' . $memberClass->student->fullname . ' - ' . $className];
                            })
                            ->toArray(),
                    )
                    ->selectableLabel('Member Class School')
                    ->selectedLabel('Selected Member Class School')
                    ->enableSearch(),
            ])
            ->columns('full');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('extracurricular_id')
            ->columns([Tables\Columns\TextColumn::make('memberClassSchool.student.fullname')->searchable()->sortable()->label('Student Name'), Tables\Columns\TextColumn::make('memberClassSchool.student.nis')->searchable()->sortable()->label('NIS'), Tables\Columns\TextColumn::make('memberClassSchool.classSchool.name')->searchable()->sortable()->label('Class School'), Tables\Columns\TextColumn::make('memberClassSchool.classSchool.level.name')->searchable()->sortable()->label('Level')])
            ->filters([
                //
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
