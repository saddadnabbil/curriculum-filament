<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use App\Models\MasterData\LearningData;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Teacher\PlanFormatifValue;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Teacher\PlanFormatifValueTechnique;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\PlanFormatifValueResource\Pages;
use App\Filament\Resources\Teacher\PlanFormatifValueResource\RelationManagers;

class PlanFormatifValueResource extends Resource
{
    protected static ?string $model = PlanFormatifValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'plan-formatif-value';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('learning_data_id')
                    ->relationship('learningData', 'id')
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
                            Rule::unique('plan_formatif_values', 'learning_data_id')->ignore($recordId)
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
                                '1' => 'Parktik',
                                '2' => 'Projek',
                                '3' => 'Produk',
                                '4' => 'Teknik 1',
                                '5' => 'Teknik 2',
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
                    ->relationship('learningData', 'id')
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
            'index' => Pages\ListPlanFormatifValues::route('/'),
            'create' => Pages\CreatePlanFormatifValue::route('/create'),
            'edit' => Pages\EditPlanFormatifValue::route('/{record}/edit'),
        ];
    }
}
