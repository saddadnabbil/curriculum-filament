<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use App\Models\Term;
use Filament\Tables;
use App\Helpers\Helper;
use App\Models\TkEvent;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TkEventResource\Pages;
use App\Filament\Resources\MasterData\TkEventResource\RelationManagers;

class TkEventResource extends Resource
{
    protected static ?string $model = TkEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Event';

    protected static ?string $modelLabel = 'Event';

    protected static ?string $slug = 'event';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Event Details')
                    ->description('')
                    ->schema([
                        Forms\Components\Select::make('academic_year_id')
                            ->relationship('academicYear', 'year')
                            ->default(function (Get $get) {
                                $academicYearId = Helper::getActiveAcademicYearId();
                                $academicYear = AcademicYear::find($academicYearId);
                                return $academicYear->id;
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('term_id')
                            ->relationship('term', 'term')
                            ->default(function (Get $get) {
                                $termPgId = Helper::getActiveTermPg();
                                $term = Term::find($termPgId);
                                return $term->id;
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan('full'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('academicYear.year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.term')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
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

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery()->whereHas('academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            });
        } else {
            return parent::getEloquentQuery()->whereHas('academicYear', function (Builder $query) {
                $query->where('id', Helper::getActiveAcademicYearId());
            })->whereHas('term', function (Builder $query) {
                $query->where('id', Helper::getActiveTermPg());
            });
        }
    }

    public static function getRecord($key): Model
    {
        return static::getEloquentQuery()->findOrFail($key);
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
            'index' => Pages\TkListEvents::route('/'),
        ];
    }
}
