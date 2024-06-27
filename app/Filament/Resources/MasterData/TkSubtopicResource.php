<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use Filament\Forms\Form;
use App\Models\TkSubtopic;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkSubtopicResource\Pages;
use App\Filament\Resources\MasterData\TkSubtopicResource\RelationManagers;

class TkSubtopicResource extends Resource
{
    protected static ?string $model = TkSubtopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Subtopic';

    protected static ?string $modelLabel = 'Subtopic';

    protected static ?string $slug = 'subtopic';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tk_topic_id')
                    ->relationship('topic', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('element.name')
                    ->label('Element Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('topic.name')
                    ->label('Topic Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Subtopic Name')
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
                    ->relationship('topic.element.level', 'name', function ($query) {
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
            'index' => Pages\ListTkSubtopics::route('/'),
        ];
    }
}
