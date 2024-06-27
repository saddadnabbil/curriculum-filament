<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use App\Helpers\Helper;
use Filament\Forms\Form;
use App\Models\TkElement;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkElementResource\Pages;
use App\Filament\Resources\MasterData\TkElementResource\RelationManagers;

class TkElementResource extends Resource
{
    protected static ?string $model = TkElement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Element';

    protected static ?string $modelLabel = 'Element';

    protected static ?string $slug = 'element';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Element Information')
                    ->description('')
                    ->schema([
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name', function ($query) {
                                return $query->whereNotIn('id', [4, 5, 6])->orderBy('id', 'asc');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Element Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable(),
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
                    ->relationship('level', 'name', function ($query) {
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
            'index' => Pages\ListTkElements::route('/'),
        ];
    }
}
