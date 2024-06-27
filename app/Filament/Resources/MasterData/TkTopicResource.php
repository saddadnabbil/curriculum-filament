<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use App\Models\TkTopic;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkTopicResource\Pages;
use App\Filament\Resources\MasterData\TkTopicResource\RelationManagers;

class TkTopicResource extends Resource
{
    protected static ?string $model = TkTopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Topic';

    protected static ?string $modelLabel = 'Topic';

    protected static ?string $slug = 'topic';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Topic Information')
                    ->description('')
                    ->schema([
                        Forms\Components\Select::make('tk_element_id')
                            ->label('Element Name')
                            ->relationship('element', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\ColorPicker::make('color')
                            ->required()
                            ->hex(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('element.name')
                    ->label('Element Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Topic Name')
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level_id')
                    ->label('Level')
                    ->relationship('element.level', 'name', function ($query) {
                        return $query->whereNotIn('id', [4, 5, 6])->orderBy('id', 'asc');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->searchable()
                    ->preload()
                    ->default(function () {
                        $query = Level::whereNotIn('id', [4, 5, 6])->first();
                        return $query ? $query->id : null;
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->deselectAllRecordsWhenFiltered(false)
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

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.master_data.report_tk");
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
            'index' => Pages\ListTkTopics::route('/'),
        ];
    }
}
