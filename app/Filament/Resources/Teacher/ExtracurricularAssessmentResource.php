<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Teacher\ExtracurricularAssessment;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\ExtracurricularAssessmentResource\Pages;
use App\Filament\Resources\Teacher\ExtracurricularAssessmentResource\RelationManagers;

class ExtracurricularAssessmentResource extends Resource
{
    protected static ?string $model = ExtracurricularAssessment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'extracurricular-assessment';

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
        return __("menu.nav_group.report_km");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtracurricularAssessments::route('/'),
            'create' => Pages\CreateExtracurricularAssessment::route('/create'),
            'edit' => Pages\EditExtracurricularAssessment::route('/{record}/edit'),
        ];
    }
}
