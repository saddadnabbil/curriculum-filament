<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Teacher\StudentDescription;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\StudentDescriptionResource\Pages;
use App\Filament\Resources\Teacher\StudentDescriptionResource\RelationManagers;

class StudentDescriptionResource extends Resource
{
    protected static ?string $model = StudentDescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'student-description';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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
        return __("menu.nav_group.report_km");
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentDescriptions::route('/'),
            'create' => Pages\CreateStudentDescription::route('/create'),
            'edit' => Pages\EditStudentDescription::route('/{record}/edit'),
        ];
    }
}
