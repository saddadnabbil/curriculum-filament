<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\MasterData\Teacher;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MasterData\Extracurricular;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Exports\MasterData\ExtracurricularExporter;
use App\Filament\Imports\MasterData\ExtracurricularImporter;
use App\Filament\Resources\MasterData\ExtracurricularResource\Pages;
use App\Filament\Resources\MasterData\ExtracurricularResource\RelationManagers;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('academic_year_id')
                    ->relationship('academicYear', 'year')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(Teacher::all()->pluck('employee_fullname', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ExtracurricularExporter::class)
                    ->fileName(fn (Export $export): string => "extracurricular-export-{$export->getKey()}")
                    ->columnMapping(false),
                ImportAction::make()
                    ->importer(ExtracurricularImporter::class),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('academicYear.year')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.employee.fullname')
                    ->label('Teacher')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->modifyQueryUsing(function (Builder $query) {
            //     $query->whereHas('academicYear', function (Builder $query) {
            //         $query->where('status', true);
            //     });
            // })
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('academicYear', function (Builder $query) {
            $query->where('status', true);
        });
    }

    public static function getRecord($key): Model
    {
        return static::getEloquentQuery()->findOrFail($key);
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.master_data");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageExtracurriculars::route('/'),
        ];
    }
}
