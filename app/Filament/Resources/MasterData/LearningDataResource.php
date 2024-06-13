<?php

namespace App\Filament\Resources\MasterData;

use App\Filament\Resources\MasterData\LearningDataResource\Pages;
use App\Filament\Resources\MasterData\LearningDataResource\RelationManagers;
use App\Models\MasterData\LearningData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LearningDataResource extends Resource
{
    protected static ?string $model = LearningData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
        return __("menu.nav_group.master_data");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLearningData::route('/'),
            'create' => Pages\CreateLearningData::route('/create'),
            'edit' => Pages\EditLearningData::route('/{record}/edit'),
        ];
    }
}
