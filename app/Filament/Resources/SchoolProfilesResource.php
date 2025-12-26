<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolProfilesResource\Pages;
use App\Models\SchoolProfile;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchoolProfilesResource extends Resource
{
    protected static ?string $model = SchoolProfile::class; 

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Manajemen Pusat';
    protected static ?string $modelLabel = 'Detail Profil Sekolah';
    protected static ?string $pluralModelLabel = 'Detail Profil Sekolah'; // (Label Jamak yang benar)

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }

    /**
     * Pembatasan kemampuan CREATE: Admin Sekolah hanya bisa membuat jika profilnya belum ada.
     */
    public static function canCreate(): bool
    {
        $user = auth()->user();
    
        if ($user instanceof User && $user->isSuperAdmin()) {
            return true;
        }
    
        if ($user instanceof User && $user->school_id !== null) {
            $hasProfile = SchoolProfile::where('school_id', $user->school_id)->exists();
            return !$hasProfile;
        }
        
        return false;
    }

    /**
     * Membatasi query agar Admin Sekolah hanya melihat datanya sendiri.
     */
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        
        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }
        
        if ($user instanceof User && $user->school_id !== null) {
            return parent::getEloquentQuery()->where('school_id', $user->school_id);
        }
        
        return parent::getEloquentQuery()->where('id', null);
    }
    
    /**
     * Mutator untuk operasi UPDATE/SAVE (melengkapi school_id jika tersembunyi).
     */
    protected static function mutateFormDataBeforeSave(array $data): array
    {
        if (!isset($data['school_id']) && auth()->check() && auth()->user()->school_id !== null) {
            $data['school_id'] = auth()->user()->school_id;
        }
        return $data;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $isSuperAdmin = $user instanceof User && $user->isSuperAdmin();
        
        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->relationship(name: 'school', titleAttribute: 'name')
                    ->label('Nama Sekolah')
                    ->default(function () {
                        return auth()->check() ? auth()->user()->school_id : null;
                    })
                    ->required()
                    ->disabled(!$isSuperAdmin)
                    ->visible($isSuperAdmin),

                Forms\Components\RichEditor::make('vision')
                    ->label('Visi Sekolah')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('logo_url')
                    ->label('Logo Sekolah')
                    ->image() // Memastikan file yang diunggah adalah gambar
                    ->directory('school-logos') // Menyimpan di folder storage/app/public/school-logos
                    ->maxSize(1024) // Batas 1MB
                    ->required(false),
                
                Forms\Components\RichEditor::make('mission')
                    ->label('Misi Sekolah')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Singkat Sekolah')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('address')
                    ->label('Alamat Lengkap Sekolah')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone')
                            ->tel()
                            ->label('Nomor Telepon')
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('contact_email')
                            ->email()
                            ->label('Email Kontak Resmi')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Fieldset::make('Informasi Kepala Sekolah')
                    ->schema([
                        Forms\Components\TextInput::make('principal_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kepala Sekolah'),
                            
                        Forms\Components\FileUpload::make('principal_photo_url')
                            ->label('Foto Kepala Sekolah')
                            ->image()
                            ->disk('public')
                            ->directory('principal-photos')
                            ->nullable(),
                            
                        Forms\Components\RichEditor::make('principal_welcome_message')
                            ->label('Pesan Sambutan Kepala Sekolah')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    /**
     * Perbaikan TABLE: Menampilkan semua kolom DB.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Utama
                Tables\Columns\TextColumn::make('school.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Sekolah')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('principal_name')
                    ->label('Kepala Sekolah')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Email Kontak')
                    ->searchable(),

                // Kolom Kontak Tambahan
                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('No. Telepon')
                    ->toggleable(isToggledHiddenByDefault: true),

                // Kolom Alamat
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn ($state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),

                // Kolom Konten Panjang
                Tables\Columns\TextColumn::make('vision')
                    ->label('Visi')
                    ->limit(20)
                    ->tooltip(fn ($state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('mission')
                    ->label('Misi')
                    ->limit(20)
                    ->tooltip(fn ($state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi Singkat')
                    ->limit(30)
                    ->tooltip(fn ($state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('principal_welcome_message')
                    ->label('Pesan Sambutan KS')
                    ->limit(30)
                    ->tooltip(fn ($state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),

                // Kolom Media (URL Foto)
                Tables\Columns\ImageColumn::make('principal_photo_url')
                    ->label('Foto KS')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // Kolom Timestamp
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(), 
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
            'index' => Pages\ListSchoolProfiles::route('/'),
            'create' => Pages\CreateSchoolProfiles::route('/create'), 
            'edit' => Pages\EditSchoolProfiles::route('/{record}/edit'), 
        ];
    } 
}