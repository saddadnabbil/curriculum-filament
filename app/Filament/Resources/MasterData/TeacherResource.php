<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\MasterData\Teacher;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\TeacherResource\Pages;
use App\Filament\Resources\MasterData\TeacherResource\RelationManagers;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')->label('Employee')
                    ->label('Employee')
                    ->relationship('employee', 'fullname')
                    ->options(function (callable $get) {
                        return Employee::whereDoesntHave('teacher')
                            ->pluck('fullname', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->createOptionForm(EmployeeResource::getForm('create') ?? [])
                    ->editOptionForm(EmployeeResource::getForm('edit') ?? []),
            ])->columns('full');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.fullname')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.employee_code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.employeeUnit.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee.employeePosition.name')
                    ->sortable()
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
        return __("menu.nav_group.master_data");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTeachers::route('/'),
        ];
    }
}
