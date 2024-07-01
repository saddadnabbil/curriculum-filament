<?php

namespace App\Filament\Resources\MasterData;

use App\Filament\Resources\MasterData\MappingSubjectResource\Pages;
use App\Filament\Resources\MasterData\MappingSubjectResource\RelationManagers;
use App\Models\MappingSubject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MappingSubjectResource extends Resource
{
    protected static ?string $model = MappingSubject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                Forms\Components\Select::make('group')
                    ->options([
                        'A' => 'Group A',
                        'B' => 'Group B',
                    ])
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('order')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('group')
                    ->options([
                        'A' => 'Group A',
                        'B' => 'Group B',
                    ]),
                Tables\Columns\TextInputColumn::make('order')
                    ->rules(['numeric'])
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
            'index' => Pages\ListMappingSubjects::route('/'),
            'create' => Pages\CreateMappingSubject::route('/create'),
            'edit' => Pages\EditMappingSubject::route('/{record}/edit'),
        ];
    }
}
