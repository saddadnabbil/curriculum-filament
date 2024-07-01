<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSchool;
use App\Models\LearningData;
use App\Models\MinimumCriteria;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\MinimumCriteriaResource\Pages;
use App\Filament\Resources\MasterData\MinimumCriteriaResource\RelationManagers;

class MinimumCriteriaResource extends Resource
{
    protected static ?string $model = MinimumCriteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Minimum Criteria')
                    ->description('')
                    ->schema([
                        Forms\Components\Select::make('class_school_id')
                            ->label('Class School')
                            ->relationship('classSchool', 'name', function ($query) {
                                $query->where('academic_year_id', Helper::getActiveAcademicYearId());
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),

                        Forms\Components\Select::make('learning_data_id')
                            ->label('Learning Data')
                            ->relationship('learningData.subject', 'name')
                            ->options(function (Get $get) {
                                $selectedClassSchool = ClassSchool::find($get('class_school_id'));

                                if ($selectedClassSchool) {
                                    $classSchoolId = $selectedClassSchool->id;

                                    // Retrieve the learning data associated with the class school ID
                                    $learningData = LearningData::where('class_school_id', $classSchoolId)->get();

                                    // Ensure learning data is a collection before plucking data
                                    if ($learningData instanceof Collection) {
                                        return $learningData->pluck('subject.name', 'id');
                                    }
                                }

                                return collect();
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('kkm')
                            ->label('Minimum Criteria')
                            ->required()
                            ->numeric()
                            ->minLength(0)
                            ->maxLength(100),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('learningData.subject.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classSchool.name')
                    ->numeric(),
                Tables\Columns\TextInputColumn::make('kkm')
                    ->rules(['numeric'])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
        return __("menu.nav_group.master_data.report_km");
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMinimumCriterias::route('/'),
            'create' => Pages\CreateMinimumCriteria::route('/create'),
            'edit' => Pages\EditMinimumCriteria::route('/{record}/edit'),
        ];
    }
}
