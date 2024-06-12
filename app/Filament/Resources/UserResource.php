<?php

namespace App\Filament\Resources;

use Exception;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Settings\MailSettings;
use Filament\Facades\Filament;
use Filament\Actions\EditAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Placeholder;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

function generateUniqueEmployeeCode(): string
{
    $code = Str::random(6); // Menghasilkan kode acak
    while (User::where('kode_karyawan', $code)->exists()) {
        $code = Str::random(6); // Ulangi jika kode sudah ada di database
    }
    return strtoupper($code);
}


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static int $globalSearchResultsLimit = 20;

    protected static ?int $navigationSort = -1;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->hiddenLabel()
                                    ->avatar()
                                    ->collection('avatars')
                                    ->alignCenter()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('username')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\ToggleButtons::make('status')
                            ->label('Status')
                            ->options([
                                '1' => 'Active',
                                '0' => 'Non active',
                            ])->inline()
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'lg' => 2
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Role')
                            ->schema([
                                Select::make('roles')->label('Role')
                                    ->hiddenLabel()
                                    ->relationship('roles', 'name')
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => Str::headline($record->name))
                                    ->multiple()
                                    ->preload()
                                    ->maxItems(1)
                                    ->native(false),
                            ])
                            ->compact(),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->revealable()
                                    ->required(),
                                Forms\Components\TextInput::make('passwordConfirmation')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->revealable()
                                    ->same('password')
                                    ->required(),
                            ])
                            ->compact()
                            ->hidden(fn (string $operation): bool => $operation === 'edit'),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('email_verified_at')
                                    ->label(__('resource.general.email_verified_at'))
                                    ->content(fn (User $record): ?string => $record->email_verified_at),
                                Forms\Components\Actions::make([
                                    Action::make('resend_verification')
                                        ->label(__('resource.user.actions.resend_verification'))
                                        ->color('secondary')
                                        ->action(fn (MailSettings $settings, Model $record) => static::doResendEmailVerification($settings, $record)),
                                ])
                                    ->hidden(fn (User $user) => $user->email_verified_at != null)
                                    ->fullWidth(),
                                Forms\Components\Placeholder::make('created_at')
                                    ->label(__('resource.general.created_at'))
                                    ->content(fn (User $record): ?string => $record->created_at?->diffForHumans()),
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label(__('resource.general.updated_at'))
                                    ->content(fn (User $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->hidden(fn (string $operation): bool => $operation === 'create'),
                    ])
                    ->columnSpan(1),

                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // Personal Information
                        Forms\Components\Tabs\Tab::make('Personal Information')
                            ->schema([
                                Forms\Components\TextInput::make('nama_lengkap')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('kode_karyawan')
                                            ->label('Employee Code')
                                            ->maxLength(25)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('nik')
                                            ->maxLength(16)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('jenis_kelamin')
                                            ->label('Gender')
                                            ->options([
                                                '1' => 'Male',
                                                '2' => 'Female',
                                            ])
                                            ->required()
                                            ->searchable(),
                                        Forms\Components\Select::make('agama')
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
                                        Forms\Components\TextInput::make('tempat_lahir')
                                            ->label('Place of Birth')
                                            ->maxLength(50)
                                            ->nullable(),
                                        Forms\Components\DatePicker::make('tanggal_lahir')
                                            ->label('Date of Birth')
                                            ->native(false)
                                            ->nullable(),
                                    ]),
                                Forms\Components\TextInput::make('warga_negara')
                                    ->label('Nationality')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('status_pernikahan')
                                            ->label('Marital Status')
                                            ->options([
                                                '1' => 'Merried',
                                                '2' => 'Single',
                                                '3' => 'Widow',
                                                '4' => 'Widower',
                                            ])
                                            ->searchable()
                                            ->nullable(),
                                        Forms\Components\TextInput::make('nama_pasangan')
                                            ->label('Spouse Name')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('jumlah_anak')
                                            ->label('Number of Children')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('keterangan')
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
                                        Forms\Components\TextInput::make('nomor_phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('nomor_hp')
                                            ->label('Mobile Number')
                                            ->tel()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('email_sekolah')
                                            ->label('School Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\TextInput::make('alamat')
                                    ->label('Current Address')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\TextInput::make('alamat_sekarang')
                                    ->label('Permanent Address')
                                    ->maxLength(255)
                                    ->nullable(),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('kota')
                                            ->label('City')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('kode_pos')
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
                                        Forms\Components\TextInput::make('nomor_taxpayer')
                                            ->label('Taxpayer Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('nama_taxpayer')
                                            ->label('Taxpayer Name')
                                            ->maxLength(255)
                                            ->nullable(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('nomor_bpjs_ketenagakerjaan')
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
                                        Forms\Components\TextInput::make('nomor_bpjs_yayasan')
                                            ->label('BPJS Number')
                                            ->maxLength(255)
                                            ->nullable(),
                                        Forms\Components\TextInput::make('nomor_bpjs_pribadi')
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
                                        Forms\Components\FileUpload::make('pas_photo')
                                            ->label('Pas Photo')
                                            ->image()
                                            ->directory('employee/pas_photo')
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
                                            ),
                                        Forms\Components\FileUpload::make('ttd')
                                            ->directory('employee/ttd')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
                                            ),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('photo_kartu_identitas')
                                            ->label('KTP Photo')
                                            ->directory('employee/photo_kartu_identitas')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
                                            ),
                                        Forms\Components\FileUpload::make('photo_taxpayer')
                                            ->label('Taxpayer Photo')
                                            ->directory('employee/photo_taxpayer')
                                            ->image()
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->nullable()
                                            ->getUploadedFileNameForStorageUsing(
                                                fn (TemporaryUploadedFile $file, Get $get): string =>
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
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
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
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
                                                $get('kode_karyawan') . '.' . $file->getClientOriginalExtension()
                                            ),
                                    ]),
                            ]),
                    ])->columns(3)->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')->label('Avatar')
                    ->collection('avatars')
                    ->circular()
                    ->wrap(),
                Tables\Columns\TextColumn::make('username')->label('Username')
                    ->description(fn (Model $record) => $record->full_name ?? $record->full_name ?? '')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label('Role')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->colors(['info'])
                    ->badge(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')->label('Verified at')
                    ->dateTime()
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->email;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['email', 'username'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'name' => $record->full_name ?? $record->full_name,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.user_management");
    }

    public static function doResendEmailVerification($settings = null, $user): void
    {
        if (!method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = new VerifyEmail();
        $notification->url = Filament::getVerifyEmailUrl($user);

        $settings->loadMailSettingsToConfig();

        $user->notify($notification);

        Notification::make()
            ->title(__('resource.user.notifications.notification_resent.title'))
            ->success()
            ->send();
    }
}
