<?php

namespace App\Filament\Resources\Teacher;

use App\Filament\Resources\Teacher\TkAchivementGradeResource\Pages;
use App\Filament\Resources\Teacher\TkAchivementGradeResource\RelationManagers;
use App\Models\TkAchivementGrade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TkAchivementGradeResource extends Resource
{
    protected static ?string $model = TkAchivementGrade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_class_school_id')
                    ->label('Student Name')
                    ->relationship('memberClassSchool.student', 'fullname')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('tk_point_id')
                    ->relationship('point', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('term_id')
                    ->label('Term')
                    ->options([
                        '1' => '1',
                        '2' => '2',
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('achivement')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member_class_school_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tk_point_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('achivement'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTkAchivementGrades::route('/'),
            'create' => Pages\CreateTkAchivementGrade::route('/create'),
            'edit' => Pages\EditTkAchivementGrade::route('/{record}/edit'),
        ];
    }
}
