<?php

namespace App\Filament\Resources\MasterData;

use App\Filament\Resources\MasterData\LevelResource\Pages;
use App\Filament\Resources\MasterData\LevelResource\RelationManagers;
use App\Models\MasterData\Level;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Level';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'semester')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('term_id')
                    ->relationship('term', 'term')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('school_id')
                    ->relationship('school', 'school_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Level Name')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('semester.semester')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school.school_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Level Name')
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
                //
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

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.master_data");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLevels::route('/'),
        ];
    }
}
