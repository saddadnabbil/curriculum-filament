<?php

namespace App\Filament\Resources\MasterData;

use App\Filament\Resources\MasterData\StudentResource\Pages;
use App\Filament\Resources\MasterData\StudentResource\RelationManagers;
use App\Models\MasterData\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('class_id')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('level_id')
                //     ->required()
                //     ->numeric(),
                // Forms\Components\TextInput::make('line_id')
                //     ->required()
                //     ->numeric(),
                Forms\Components\Select::make('class_id')
                    ->label('Class')
                    ->searchable()
                    ->preload()
                    ->relationship('class', 'name')
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->label('Level')
                    ->searchable()
                    ->preload()
                    ->relationship('level', 'name')
                    ->required(),
                Forms\Components\Select::make('line_id')
                    ->label('Line')
                    ->searchable()
                    ->preload()
                    ->relationship('line', 'name')
                    ->required(),
                Forms\Components\Select::make('registration_type')
                    ->options([
                        '1' => 'New Student',
                        '2' => 'Transfer Student',
                    ]),
                Forms\Components\TextInput::make('entry_year')
                    ->maxLength(255),
                Forms\Components\TextInput::make('entry_semester')
                    ->maxLength(255),
                Forms\Components\TextInput::make('entry_class')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->numeric()
                    ->minLength(10),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->maxLength(10),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('fullname')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->maxLength(16),
                Forms\Components\Select::make('gender')
                    ->options([
                        '1' => 'Male',
                        '2' => 'Female',
                    ]),
                Forms\Components\Select::make('blood_type')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'AB' => 'AB',
                        'O' => 'O',
                    ]),
                Forms\Components\Select::make('religion')
                ->options([
                    '1' => 'Islam',
                    '2' => 'Protestan',
                    '3' => 'Katolik',
                    '4' => 'Hindu',
                    '5' => 'Buddha',
                    '6' => 'Konghucu',
                    '7' => 'Lainnya',
                ]),
                Forms\Components\TextInput::make('place_of_birth')
                    ->maxLength(50),
                Forms\Components\DatePicker::make('date_of_birth')->native(false),
                Forms\Components\TextInput::make('anak_ke')
                    ->maxLength(2),
                Forms\Components\TextInput::make('number_of_sibling')
                    ->maxLength(2),
                Forms\Components\TextInput::make('citizen')
                    ->maxLength(255),
                Forms\Components\TextInput::make('photo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')
                    ->numeric(),
                Forms\Components\TextInput::make('distance_home_to_school')
                    ->numeric(),
                Forms\Components\TextInput::make('email_parent')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('living_together'),
                Forms\Components\TextInput::make('transportation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_father')
                    ->maxLength(16),
                Forms\Components\TextInput::make('father_name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('father_place_of_birth')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('father_date_of_birth'),
                Forms\Components\TextInput::make('father_address')
                    ->maxLength(100),
                Forms\Components\TextInput::make('father_phone_number')
                    ->maxLength(13),
                Forms\Components\TextInput::make('father_religion'),
                Forms\Components\TextInput::make('father_city')
                    ->maxLength(100),
                Forms\Components\TextInput::make('father_last_education')
                    ->maxLength(25),
                Forms\Components\TextInput::make('pekerjaan_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('father_income')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik_mother')
                    ->maxLength(16),
                Forms\Components\TextInput::make('mother_name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('mother_place_of_birth')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('mother_date_of_birth'),
                Forms\Components\TextInput::make('mother_address')
                    ->maxLength(100),
                Forms\Components\TextInput::make('mother_phone_number')
                    ->maxLength(13),
                Forms\Components\TextInput::make('mother_religion'),
                Forms\Components\TextInput::make('mother_city')
                    ->maxLength(100),
                Forms\Components\TextInput::make('mother_last_education')
                    ->maxLength(25),
                Forms\Components\TextInput::make('mother_job')
                    ->maxLength(100),
                Forms\Components\TextInput::make('mother_income')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik_guardian')
                    ->maxLength(16),
                Forms\Components\TextInput::make('guardian_name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('guardian_place_of_birth')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('guardian_date_of_birth'),
                Forms\Components\TextInput::make('guardian_address')
                    ->maxLength(100),
                Forms\Components\TextInput::make('guardian_phone_number')
                    ->maxLength(13),
                Forms\Components\TextInput::make('guardion_religion'),
                Forms\Components\TextInput::make('guardian_city')
                    ->maxLength(100),
                Forms\Components\TextInput::make('guardian_last_education')
                    ->maxLength(25),
                Forms\Components\TextInput::make('guardian_job')
                    ->maxLength(100),
                Forms\Components\TextInput::make('guardian_income')
                    ->maxLength(100),
                Forms\Components\TextInput::make('height')
                    ->maxLength(255),
                Forms\Components\TextInput::make('weight')
                    ->maxLength(255),
                Forms\Components\TextInput::make('special_treatment')
                    ->maxLength(255),
                Forms\Components\TextInput::make('note_health')
                    ->maxLength(255),
                Forms\Components\TextInput::make('photo_document_health')
                    ->maxLength(255),
                Forms\Components\TextInput::make('photo_list_questions')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('old_school_entry_date'),
                Forms\Components\DatePicker::make('old_school_leaving_date'),
                Forms\Components\TextInput::make('old_school_name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('old_school_achivements_year')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tahun_old_school_achivements_year')
                    ->maxLength(100),
                Forms\Components\TextInput::make('certificate_number_old_school')
                    ->maxLength(100),
                Forms\Components\TextInput::make('old_school_address')
                    ->maxLength(100),
                Forms\Components\TextInput::make('no_sttb')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nem')
                    ->numeric(),
                Forms\Components\TextInput::make('photo_document_old_school')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('class.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('line.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
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
        return __("menu.nav_group.master_data");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
