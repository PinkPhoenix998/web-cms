<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolResource\Pages;
use App\Models\School;
use App\Models\User; 
use App\Models\SchoolProfile; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Manajemen Pusat';
    protected static ?string $modelLabel = 'Data Sekolah (Tenant)';
    // [FIX]: Menghilangkan "s" otomatis dari nama menu
    protected static ?string $pluralModelLabel = 'Data Sekolah (Tenant)'; 

    // Otorisasi: Hanya Admin Pusat yang bisa melihat resource ini
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && $user->isSuperAdmin();
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan Tenant dan Profil Sekolah')
                    ->tabs([
                        // TAB 1: DATA TENANT UTAMA (dari tabel schools)
                        Forms\Components\Tabs\Tab::make('Data Utama Tenant')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nama Sekolah'),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true, table: School::class)
                                    ->label('Slug/URL Unik'),
                                    
                                Forms\Components\FileUpload::make('logo_url')
                                    ->image()
                                    ->disk('public')
                                    ->directory('logos')
                                    ->columnSpanFull()
                                    ->label('Logo Sekolah'),
                            ]),

                        // TAB 2: DATA PROFIL (dari tabel school_profiles melalui relasi profile())
                        Forms\Components\Tabs\Tab::make('Detail Profil (Visi, Misi, Kontak)')
                            ->schema([
                                Forms\Components\Repeater::make('profile') 
                                    ->label('Detail Profil Sekolah')
                                    ->relationship('profile') 
                                    ->schema([
                                        Forms\Components\Section::make('Visi & Misi')
                                            ->columns(1)
                                            ->schema([
                                                Forms\Components\RichEditor::make('description')
                                                    ->label('Deskripsi Singkat Profil Sekolah'),
                                                Forms\Components\RichEditor::make('vision')
                                                    ->label('Visi Sekolah'),
                                                Forms\Components\RichEditor::make('mission')
                                                    ->label('Misi Sekolah'),
                                            ]),
                                        Forms\Components\Section::make('Kepala Sekolah & Kontak')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('principal_name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Nama Kepala Sekolah'),
                                                Forms\Components\FileUpload::make('principal_photo_url')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('principals')
                                                    ->label('Foto Kepala Sekolah'),
                                                Forms\Components\RichEditor::make('principal_welcome_message')
                                                    ->columnSpanFull()
                                                    ->label('Kata Sambutan Kepala Sekolah'),
                                                Forms\Components\TextInput::make('address')
                                                    ->columnSpanFull()
                                                    ->label('Alamat Lengkap'),
                                                Forms\Components\TextInput::make('contact_phone')
                                                    ->tel()
                                                    ->label('Nomor Telepon'),
                                                Forms\Components\TextInput::make('contact_email')
                                                    ->email()
                                                    ->label('Email Kontak Resmi'),
                                            ]),
                                    ])
                                    ->minItems(1) 
                                    ->maxItems(1) 
                                    ->defaultItems(1)
                                    ->grid(1)
                                    ->columnSpanFull(),
                            ]),
                        
                    ])->columnSpanFull(),
            ]);
    }

    /**
     * PERBAIKAN TABLE: FIX BADMETHODCALLEXCEPTION pada IconColumn.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sekolah'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL Slug'),
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo'),

                // Kolom Email Admin
                Tables\Columns\TextColumn::make('admin.email') 
                    ->label('Email Admin')
                    ->searchable()
                    ->placeholder('Admin Belum Terdaftar'), 

                // [✅ FIX BADMETHODCALLEXCEPTION]: Menggunakan getStateUsing()
                Tables\Columns\IconColumn::make('admin.password')
                    ->label('Password Set')
                    // 1. Dapatkan state ('set' atau 'unset')
                    ->getStateUsing(fn (School $record): string => $record->admin?->password ? 'set' : 'unset') 
                    // 2. Tentukan ikon berdasarkan state
                    ->icon(fn (string $state): string => match ($state) {
                        'set' => 'heroicon-o-lock-closed',
                        'unset' => 'heroicon-o-exclamation-triangle',
                        default => 'heroicon-o-question-mark',
                    })
                    // 3. Tentukan warna berdasarkan state
                    ->color(fn (string $state): string => match ($state) {
                        'set' => 'success',
                        'unset' => 'danger',
                        default => 'gray',
                    })
                    ->tooltip(fn (string $state): string => match ($state) {
                        'set' => 'Password Sudah Disetel',
                        'unset' => 'Password Belum Disetel',
                        default => 'Tidak Diketahui',
                    })
                    ->toggleable(isToggledHiddenByDefault: true), 
                
                // Kolom kontak dan kepala sekolah diakses via relasi 'profile()'
                // Tables\Columns\TextColumn::make('profile.principal_name') 
                //     ->label('Kepala Sekolah')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('profile.contact_email')
                    ->label('Email Kontak Resmi')
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
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
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