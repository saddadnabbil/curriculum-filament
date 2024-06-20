<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use App\Models\MasterData\LearningData;
use App\Models\Teacher\PlanSumatifValue;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\PlanSumatifValueResource\Pages;
use App\Filament\Resources\Teacher\PlanSumatifValueResource\RelationManagers;

class PlanSumatifValueResource extends Resource
{
    protected static ?string $model = PlanSumatifValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                Select::make('learning_data_id')
                    ->relationship('learningData', 'id', function ($query) {
                        return $query->with('subject');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->subject->name . ' - ' . $record->classSchool->name)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $learningData = LearningData::with('classSchool.level.semester')->find($state);
                        $semesterId = $learningData ? $learningData->classSchool->level->semester->id : null;
                        $set('semester_id', $semesterId);
                    }),
                Hidden::make('semester_id'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('learning_data_id')
                    ->label('Learning Data')
                    ->relationship('learningData', 'id', function ($query) {
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
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->subject->name . ' - ' . $record->classSchool->name)
                    ->searchable()
                    ->preload()
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(1)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
