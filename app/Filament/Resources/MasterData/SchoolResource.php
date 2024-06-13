<?php

namespace App\Filament\Resources\MasterData;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Models\MasterData\School;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\EditAction;
use App\Models\MasterData\AcademicYear;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterData\SchoolResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\MasterData\SchoolResource\Pages\EditSchool;
use App\Filament\Resources\MasterData\SchoolResource\RelationManagers;
use App\Filament\Resources\MasterData\SchoolResource\Pages\ListSchools;
use App\Filament\Resources\MasterData\SchoolResource\Pages\CreateSchool;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'School Profile';

    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        // Get the active academic year
        $activeAcademicYear = AcademicYear::where('status', true)->first();

        return $form
            ->schema([
                Forms\Components\Hidden::make('academic_year_id')
                    ->default($activeAcademicYear ? $activeAcademicYear->id : null),
                Forms\Components\TextInput::make('school_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('npsn')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('nss')
                    ->maxLength(15),
                Forms\Components\TextInput::make('postal_code')
                    ->required()
                    ->maxLength(5),
                Forms\Components\TextInput::make('number_phone')
                    ->tel()
                    ->maxLength(13),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->maxLength(100),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(35),
                Forms\Components\FileUpload::make('logo')
                    ->directory('schools/logo')
                    ->image()
                    ->visibility('public')
                    ->moveFiles()
                    ->required()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, Get $get): string =>
                        $get('npsn') . '.' . $file->getClientOriginalExtension()
                    ),
                Forms\Components\TextInput::make('principal')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nip_principal')
                    ->required()
                    ->numeric()
                    ->maxLength(18),
                Forms\Components\FileUpload::make('signature_principal')
                    ->directory('schools/signatue_principal')
                    ->image()
                    ->visibility('public')
                    ->moveFiles()
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, Get $get): string =>
                        $get('npsn') . '.' . $file->getClientOriginalExtension()
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('academicYear.year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('principal')
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
            'index' => Pages\ListSchools::route('/'),
            'create' => Pages\CreateSchool::route('/create'),
            'edit' => Pages\EditSchool::route('/{record}/edit'),
        ];
    }
}
