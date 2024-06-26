<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PancasilaRaportGroup;
use App\Models\PancasilaRaportProject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\PancasilaRaportProjectResource\Pages;
use App\Filament\Resources\Teacher\PancasilaRaportProjectResource\RelationManagers;

class PancasilaRaportProjectResource extends Resource
{
    protected static ?string $model = PancasilaRaportProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('pancasila_raport_group_id')
                    ->options(PancasilaRaportGroup::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->label('Group')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pancasila_raport_group_id')
                    ->label('Group')
                    ->formatStateUsing(fn (int $state) => PancasilaRaportGroup::find($state)->name),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.report_p5");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePancasilaRaportProjects::route('/'),
            'tree-list' => Pages\PancasilaRaportProjectTree::route('/tree-list'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereNotNull('parent_id');
    }
}
