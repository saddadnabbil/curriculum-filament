<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PancasilaRaportProjectGroup;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PancasilaRaportProjectGroupResource\Pages;
use App\Filament\Resources\PancasilaRaportProjectGroupResource\RelationManagers;
use App\Filament\Resources\Teacher\PancasilaRaportProjectGroupResource\Pages\ManagePancasilaRaportProjectGroups;

class PancasilaRaportProjectGroupResource extends Resource
{
    protected static ?string $model = PancasilaRaportProjectGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tema Project')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tema Project')
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
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->form([
                        Checkbox::make('force_delete')
                            ->label('I really want to delete this record')
                            ->helperText('This action can\'t be undo, it will delete all the related record. ')
                    ])
                    ->before(function (Action $action, PancasilaRaportProjectGroup $record, array $data) {
                        if (!$data['force_delete'] && $record->subProject()->exists()) {
                            Notification::make()
                                ->title("There is active sub project")
                                ->danger()
                                ->send();
                            $action->halt();
                        }
                    }),
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
            'index' => ManagePancasilaRaportProjectGroups::route('/'),
        ];
    }
}
