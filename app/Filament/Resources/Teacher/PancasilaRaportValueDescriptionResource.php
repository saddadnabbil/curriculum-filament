<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PancasilaRaportValueDescription;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PancasilaRaportValueDescriptionResource\Pages;
use App\Filament\Resources\PancasilaRaportValueDescriptionResource\RelationManagers;
use App\Filament\Resources\Teacher\PancasilaRaportValueDescriptionResource\Pages\ManagePancasilaRaportValueDescriptions;

class PancasilaRaportValueDescriptionResource extends Resource
{
    protected static ?string $model = PancasilaRaportValueDescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
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
        return __("menu.nav_group.report_p5");
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePancasilaRaportValueDescriptions::route('/'),
        ];
    }
}
