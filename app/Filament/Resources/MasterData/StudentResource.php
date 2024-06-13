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
                Forms\Components\TextInput::make('jenis_pendaftaran')
                    ->required(),
                Forms\Components\TextInput::make('tahun_masuk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('semester_masuk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelas_masuk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->numeric()
                    ->minLength(10),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(10),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nama_panggilan')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(16),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required(),
                Forms\Components\TextInput::make('blood_type'),
                Forms\Components\TextInput::make('agama'),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(50),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\TextInput::make('anak_ke')
                    ->maxLength(2),
                Forms\Components\TextInput::make('jml_saudara_kandung')
                    ->maxLength(2),
                Forms\Components\TextInput::make('warga_negara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pas_photo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kota')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                    ->numeric(),
                Forms\Components\TextInput::make('jarak_rumah_ke_sekolah')
                    ->numeric(),
                Forms\Components\TextInput::make('email_parent')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_hp')
                    ->maxLength(13),
                Forms\Components\TextInput::make('tinggal_bersama'),
                Forms\Components\TextInput::make('transportasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_ayah')
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tempat_lahir_ayah')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal_lahir_ayah'),
                Forms\Components\TextInput::make('alamat_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nomor_hp_ayah')
                    ->maxLength(13),
                Forms\Components\TextInput::make('agama_ayah'),
                Forms\Components\TextInput::make('kota_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('pendidikan_terakhir_ayah')
                    ->maxLength(25),
                Forms\Components\TextInput::make('pekerjaan_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('penghasil_ayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik_ibu')
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_ibu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tempat_lahir_ibu')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal_lahir_ibu'),
                Forms\Components\TextInput::make('alamat_ibu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nomor_hp_ibu')
                    ->maxLength(13),
                Forms\Components\TextInput::make('agama_ibu'),
                Forms\Components\TextInput::make('kota_ibu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('pendidikan_terakhir_ibu')
                    ->maxLength(25),
                Forms\Components\TextInput::make('pekerjaan_ibu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('penghasil_ibu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik_wali')
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama_wali')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tempat_lahir_wali')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal_lahir_wali'),
                Forms\Components\TextInput::make('alamat_wali')
                    ->maxLength(100),
                Forms\Components\TextInput::make('nomor_hp_wali')
                    ->maxLength(13),
                Forms\Components\TextInput::make('agama_wali'),
                Forms\Components\TextInput::make('kota_wali')
                    ->maxLength(100),
                Forms\Components\TextInput::make('pendidikan_terakhir_wali')
                    ->maxLength(25),
                Forms\Components\TextInput::make('pekerjaan_wali')
                    ->maxLength(100),
                Forms\Components\TextInput::make('penghasil_wali')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tinggi_badan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('berat_badan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('spesial_treatment')
                    ->maxLength(255),
                Forms\Components\TextInput::make('note_kesehatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_document_kesehatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_list_pertanyaan')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_masuk_sekolah_lama'),
                Forms\Components\DatePicker::make('tanggal_keluar_sekolah_lama'),
                Forms\Components\TextInput::make('nama_sekolah_lama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('prestasi_sekolah_lama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tahun_prestasi_sekolah_lama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('sertifikat_number_sekolah_lama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('alamat_sekolah_lama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('no_sttb')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nem')
                    ->numeric(),
                Forms\Components\TextInput::make('file_dokument_sekolah_lama')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('class_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('line_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pendaftaran'),
                Tables\Columns\TextColumn::make('tahun_masuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester_masuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas_masuk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_panggilan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('blood_type'),
                Tables\Columns\TextColumn::make('agama'),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jml_saudara_kandung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warga_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pas_photo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_pos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jarak_rumah_ke_sekolah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_parent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinggal_bersama'),
                Tables\Columns\TextColumn::make('transportasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir_ayah')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama_ayah'),
                Tables\Columns\TextColumn::make('kota_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penghasil_ayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir_ibu')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama_ibu'),
                Tables\Columns\TextColumn::make('kota_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penghasil_ibu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir_wali')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_hp_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama_wali'),
                Tables\Columns\TextColumn::make('kota_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penghasil_wali')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spesial_treatment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note_kesehatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_document_kesehatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_list_pertanyaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_masuk_sekolah_lama')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_keluar_sekolah_lama')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_sekolah_lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prestasi_sekolah_lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_prestasi_sekolah_lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sertifikat_number_sekolah_lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_sekolah_lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_sttb')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nem')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_dokument_sekolah_lama')
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
