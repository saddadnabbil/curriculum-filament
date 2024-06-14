<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\Pages\EditEmployee;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use App\Filament\Resources\EmployeeResource\Pages\CreateEmployee;
use App\Filament\Resources\EmployeeResource\RelationManagers\UserRelationManager;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id'),
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // Personal Information
                        Forms\Components\Tabs\Tab::make('Personal Information')
                            ->schema([

                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('fullname')
                                            ->label('Full Name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('employee_code')
                                            ->label('Employee Code')
                                            ->maxLength(25)
                                            ->required(),

                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('nik')
                                            ->label('NIK')
                                            ->maxLength(16)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('citizen')
                                            ->label('Nationality')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                // Check if the email exists in the User model
                                                $emailExists = User::where('email', $state)->exists();

                                                if ($emailExists) {
                                                    // If email exists, set an error message
                                                    $set('emailHelperText', 'Email is already taken.');
                                                    $set('emailError', true);
                                                } else {
                                                    // Otherwise, clear the error message
                                                    $set('emailHelperText', null);
                                                    $set('emailError', false);
                                                }
                                            })
                                            ->required()
                                            ->helperText(fn ($get) => $get('emailHelperText'))
                                            ->helperTextColor(fn ($get) => $get('emailError') ? 'text-danger-600' : 'text-gray-600')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email_school')
                                            ->label('School Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('gender')
                                            ->label('Gender')
                                            ->options([
                                                '1' => 'Male',
                                                '2' => 'Female',
                                            ])
                                            ->required()
                                            ->searchable(),
                                        Forms\Components\Select::make('religion')
                                            ->label('Religion')
                                            ->options([
                                                '1' => 'Islam',
                                                '2' => 'Kristen',
                                                '3' => 'Katolik',
                                                '4' => 'Hindu',
                                                '5' => 'Budha',
                                                '6' => 'Konghucu',
                                                '7' => 'Lainnya',
                                            ])
                                            ->required()
                                            ->searchable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('place_of_birth')
                                            ->label('Place of Birth')
                                            ->maxLength(50)
                                            ->nullable(),
                                        Forms\Components\DatePicker::make('date_of_birth')
                                            ->label('Date of Birth')
                                            ->required()
                                            ->native(false),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('marital_status')
                                            ->label('Marital Status')
                                            ->options([
                                                '1' => 'Merried',
                                                '2' => 'Single',
                                                '3' => 'Widow',
                                                '4' => 'Widower',
                                            ])
                                            ->searchable()
                                            ->nullable(),
                                        Forms\Components\TextInput::make('partner_name')
                                            ->label('Spouse Name')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('number_of_childern')
                                            ->label('Number of Children')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('notes')
                                            ->label('Notes')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                            ]),

                        // Employment Information
                        Forms\Components\Tabs\Tab::make('Employment Information')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('employee_status_id')
                                            ->label('Employee Status')
                                            ->relationship(name: 'employeeStatus', titleAttribute: 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Forms\Components\Select::make('employee_unit_id')
                                            ->label('Employee Unit')
                                            ->relationship(name: 'employeeUnit', titleAttribute: 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                    ]),
                                Select::make('role_id')->label('Role')
                                    ->relationship('user.roles', 'name')
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                                    ->multiple()
                                    ->preload()
                                    ->maxItems(1)
                                    ->native(false),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('employee_position_id')
                                            ->label('Employee Position')
                                            ->relationship(name: 'employeePosition', titleAttribute: 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Forms\Components\DatePicker::make('join_date')
                                            ->label('Join Date')
                                            ->native(false)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\DatePicker::make('resign_date')
                                            ->label('Resignation Date')
                                            ->native(false)
                                            ->nullable(),
                                        Forms\Components\DatePicker::make('permanent_date')
                                            ->label('Permanent Date')
                                            ->native(false)
                                            ->nullable(),
                                    ]),
                            ]),
                        // Contact Information
                        Forms\Components\Tabs\Tab::make('Contact Information')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('phone_number')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\TextInput::make('address')
                                    ->label('Current Address')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\TextInput::make('address_now')
                                    ->label('Permanent Address')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')
                                            ->label('City')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('postal_code')
                                            ->label('Zip Code')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                            ]),

                        // Tax and Insurance Information
                        Forms\Components\Tabs\Tab::make('Tax and Insurance Information')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('number_npwp')
                                            ->label('Taxpayer Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('name_npwp')
                                            ->label('Taxpayer Name')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('number_bpjs_ketenagakerjaan')
                                            ->label('BPJS Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('iuran_bpjs_ketenagakerjaan')
                                            ->label('BPJS Iuran')
                                            ->numeric()
                                            ->prefix('Rp. ')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('number_bpjs_yayasan')
                                            ->label('BPJS Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('number_bpjs_pribadi')
                                            ->label('BPJS Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                            ]),

                        // Documents
                        Forms\Components\Tabs\Tab::make('Documents')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('photo')
                                            ->label('Pas Photo')
                                            ->image()
                                            ->directory('employee/photo')
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                        Forms\Components\FileUpload::make('signature')
                                            ->directory('employee/signature')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('photo_ktp')
                                            ->label('KTP Photo')
                                            ->directory('employee/photo_ktp')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                        Forms\Components\FileUpload::make('photo_npwp')
                                            ->label('Taxpayer Photo')
                                            ->directory('employee/photo_npwp')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('photo_kk')
                                            ->label('KK Photo')
                                            ->directory('employee/photo_kk')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                        Forms\Components\FileUpload::make('other_document')
                                            ->label('Other Document')
                                            ->directory('employee/other_document')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->preserveFilenames()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('employee_code') . '.' . $file->getClientOriginalExtension()
                                            ),
                                    ]),
                            ]),
                    ])->columns(3)->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')->label('Full Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_code')->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employeeUnit.name')->label('Employee Unit'),
                Tables\Columns\TextColumn::make('employeePosition.name')->label('Employee Position'),
                Tables\Columns\TextColumn::make('employeeStatus.name')->label('Employee Status'),
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
            UserRelationManager::class,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.user_management");
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
