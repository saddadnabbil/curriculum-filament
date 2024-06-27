<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Level;
use App\Helpers\Helper;
use App\Models\Teacher;
use App\Models\TkTopic;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ClassSchool;
use App\Models\TkLearningData;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkLearningDataResource\Pages;
use App\Filament\Resources\MasterData\TkLearningDataResource\RelationManagers;

class TkLearningDataResource extends Resource
{
    protected static ?string $model = TkLearningData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Learning Data';

    protected static ?string $modelLabel = 'Learning Data';

    protected static ?string $slug = 'learning-data';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tk_topic_id')
                    ->label('Topic Name')
                    ->required()
                    ->relationship('topic', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('class_school_id')
                    ->required()
                    ->relationship('classSchool', 'name', function (Builder $query) {
                        $query->whereNotIn('level_id', [4, 5, 6])->orderBy('id', 'asc');
                    })
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('level_id')
                    ->required()
                    ->relationship('level', 'name', function (Builder $query) {
                        $query->whereNotIn('id', [4, 5, 6])->orderBy('id', 'asc');
                    })
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(function () {
                        return Teacher::with('employee')->get()->pluck('employee.fullname', 'id')->toArray();
                    })
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('topic.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('classSchool.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('teacher_id')
                    ->label('Teacher')
                    ->options(function () {
                        return \App\Models\Teacher::with('employee')->get()->pluck('employee.fullname', 'id')->toArray();
                    })
                    ->searchable()
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
                SelectFilter::make('class_school_id')
                    ->label('Class School')
                    ->relationship('classSchool', 'name', function (Builder $query) {
                        $activeAcademicYearId = Helper::getActiveAcademicYearId();
                        return $query->where('academic_year_id', $activeAcademicYearId)->orderBy('id', 'asc');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->searchable()
                    ->preload()
                    ->default(function () {
                        $query = ClassSchool::where('academic_year_id', Helper::getActiveAcademicYearId())->first();
                        return $query ? $query->id : null;
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->deselectAllRecordsWhenFiltered(false)
            ->filtersFormColumns(1)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.master_data.report_tk");
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
            'index' => Pages\ListTkLearningData::route('/'),
        ];
    }
}
