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
use App\Models\Teacher\LearningOutcome;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\LearningOutcomeResource\Pages;
use App\Filament\Resources\Teacher\LearningOutcomeResource\RelationManagers;

class LearningOutcomeResource extends Resource
{
    protected static ?string $model = LearningOutcome::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Repeater::make('learning_outcomes')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(10),
                        TextInput::make('name')
                            ->label('Learning Outcome')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('summary')
                            ->required()
                            ->maxLength(150),
                    ])
                    ->columns(2)
                    ->required() // Ensure that repeater is required
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->collapsible(),
            ])->columns('full');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->hasRole('super_admin')) {
                    return $query;
                } else {
                    $user = auth()->user();
                    if ($user && $user->employee && $user->employee->teacher) {
                        $teacherId = $user->employee->teacher->id;
                        return $query->whereHas('learningData', function (Builder $query) use ($teacherId) {
                            $query->where('teacher_id', $teacherId);
                        });
                    }
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('learningData.subject.name')
                    ->label('Learning Data')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('learningData.classSchool.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('learningData.classSchool.level.semester.semester')
                    ->searchable()
                    ->sortable(),
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

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.report_km");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearningOutcomes::route('/'),
            'create' => Pages\CreateLearningOutcome::route('/create'),
            'edit' => Pages\EditLearningOutcome::route('/{record}/edit'),
        ];
    }
}
