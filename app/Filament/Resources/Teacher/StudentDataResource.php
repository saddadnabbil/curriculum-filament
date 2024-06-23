<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentData;
use Filament\Resources\Resource;
use App\Models\MasterData\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\StudentDataResource\Pages;
use App\Filament\Resources\Teacher\StudentDataResource\RelationManagers;

class StudentDataResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = -1;

    protected static ?string $slug = 'student-data';

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
                Tables\Actions\ViewAction::make(),
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
        return __("menu.nav_group.report_km_homeroom");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentData::route('/'),
            'create' => Pages\CreateStudentData::route('/create'),
            'view' => Pages\ViewStudentData::route('/{record}'),
            'edit' => Pages\EditStudentData::route('/{record}/edit'),
        ];
    }
}
