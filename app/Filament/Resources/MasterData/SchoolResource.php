<?php

namespace App\Filament\Resources\MasterData;

use App\Filament\Resources\MasterData\SchoolResource\Pages;
use App\Filament\Resources\MasterData\SchoolResource\RelationManagers;
use App\Models\MasterData\School;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('academic_year_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('school_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('npsn')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('nss')
                    ->maxLength(15),
                Forms\Components\TextInput::make('postal_code')
                    ->required()
                    ->maxLength(5),
                Forms\Components\TextInput::make('number_phone')
                    ->tel()
                    ->maxLength(13),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->maxLength(100),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(35),
                Forms\Components\TextInput::make('logo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('prinsipal')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nip_prinsipal')
                    ->required()
                    ->maxLength(18),
                Forms\Components\TextInput::make('signature_prinsipal')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('academic_year_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nss')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prinsipal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip_prinsipal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('signature_prinsipal')
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
