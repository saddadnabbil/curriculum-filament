<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Helpers\Helper;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\Pages\ViewEmployee;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use App\Filament\Resources\EmployeeResource\Pages\ListEmployees;

class EmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Employees';

    protected static ?string $navigationGroup = 'User Management';

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
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employeeStatus.name')
                    ->label('Status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employeeUnit.name')
                    ->label('Unit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employeePosition.name')
                    ->label('Position')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_karyawan')
                    ->label('Employee Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Details')
                    ->schema([
                        TextEntry::make('username')->label('Username'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('roles.name')->label('Role')->badge(function (): string {
                            return request()->user()->getRoleNames()[0];
                        }),
                    ])->columns(3),

                Section::make('Personal Information')
                    ->schema([
                        TextEntry::make('nama_lengkap')->label('Full Name'),
                        TextEntry::make('kode_karyawan')->label('Employee Code'),
                        TextEntry::make('nik')->label('NIK'),
                        TextEntry::make('jenis_kelamin')
                            ->label('Gender')
                            ->formatStateUsing(fn (string $state): string => Helper::getSex($state)),
                        TextEntry::make('agama')->label('Religion')->formatStateUsing(fn (string $state): string => Helper::getReligion($state)),
                        TextEntry::make('tempat_lahir')->label('Place of Birth'),
                        TextEntry::make('tanggal_lahir')->label('Date of Birth')->formatStateUsing(fn (string $state): string => Helper::getDate($state)),
                        TextEntry::make('warga_negara')->label('Nationality'),
                        TextEntry::make('status_pernikahan')->label('Marital Status')->formatStateUsing(fn (string $state): string => Helper::getMaritalStatus($state)),
                        TextEntry::make('nama_pasangan')->label('Spouse Name'),
                        TextEntry::make('jumlah_anak')->label('Number of Children'),
                        TextEntry::make('keterangan')->label('Notes'),
                    ])->columns(2),

                Section::make('Employment Information')
                    ->schema([
                        TextEntry::make('employeeStatus.name')->label('Employee Status'),
                        TextEntry::make('employeeUnit.name')->label('Employee Unit'),
                        TextEntry::make('employeePosition.name')->label('Employee Position'),
                        TextEntry::make('join_date')->label('Join Date')->formatStateUsing(fn (string $state): string => Helper::getDate($state)),
                        TextEntry::make('resign_date')->label('Resignation Date')->formatStateUsing(fn (string $state): string => Helper::getDate($state)),
                        TextEntry::make('permanent_date')->label('Permanent Date')->formatStateUsing(fn (string $state): string => Helper::getDate($state)),
                    ])->columns(2),

                Section::make('Contact Information')
                    ->schema([
                        TextEntry::make('nomor_phone')->label('Phone Number'),
                        TextEntry::make('nomor_hp')->label('Mobile Number'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('email_sekolah')->label('School Email'),
                        TextEntry::make('alamat')->label('Current Address'),
                        TextEntry::make('alamat_sekarang')->label('Permanent Address'),
                        TextEntry::make('kota')->label('City'),
                        TextEntry::make('kode_pos')->label('Zip Code'),
                    ])->columns(2),

                Section::make('Tax and Insurance Information')
                    ->schema([
                        TextEntry::make('nomor_taxpayer')->label('Taxpayer Number'),
                        TextEntry::make('nama_taxpayer')->label('Taxpayer Name'),
                        TextEntry::make('nomor_bpjs_ketenagakerjaan')->label('BPJS Number'),
                        TextEntry::make('iuran_bpjs_ketenagakerjaan')->label('BPJS Iuran'),
                        TextEntry::make('nomor_bpjs_yayasan')->label('BPJS Number'),
                        TextEntry::make('nomor_bpjs_pribadi')->label('BPJS Number'),
                    ])->columns(2),

                Section::make('Documents')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('pas_photo')->label('Pas Photo'),
                        SpatieMediaLibraryImageEntry::make('ttd')->label('Ttd'),
                        SpatieMediaLibraryImageEntry::make('photo_kartu_identitas')->label('KTP Photo'),
                        SpatieMediaLibraryImageEntry::make('photo_taxpayer')->label('Taxpayer Photo'),
                        SpatieMediaLibraryImageEntry::make('photo_kk')->label('KK Photo'),
                        SpatieMediaLibraryImageEntry::make('photo_kk')->label('photo_kk Document'),
                    ])->columns(2),
            ]);
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
            'index' => Pages\ListEmployees::route('/'),
            'view' => Pages\ViewEmployee::route('/{record}'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.user_management");
    }

    public static function canCreate(): bool
    {
        return false; // Return false to prevent creation
    }
}
