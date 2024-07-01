<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use App\Helpers\Helper;
use App\Models\TkPoint;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkPointResource\Pages;
use App\Filament\Resources\MasterData\TkPointResource\RelationManagers;

class TkPointResource extends Resource
{
    protected static ?string $model = TkPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationLabel = 'Point';

    protected static ?string $modelLabel = 'Point';

    protected static ?string $slug = 'point';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tk_topic_id')
                    ->relationship('topic', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('tk_subtopic_id')
                    ->relationship('subtopic', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('term_id')
                    ->relationship('term', 'term')
                    ->preload()
                    ->searchable()
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
                Tables\Columns\TextColumn::make('subtopic.name')
                    ->label('Subtopic Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.term')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('term', function (Builder $query) {
            $query->where('id', Helper::getActiveTermPg());
        });
    }

    public static function getRecord($key): Model
    {
        return static::getEloquentQuery()->findOrFail($key);
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
            'index' => Pages\ListTkPoints::route('/'),
        ];
    }
}
