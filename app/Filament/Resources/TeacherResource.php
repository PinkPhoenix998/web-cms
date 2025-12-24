<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use App\Models\User; // Penting untuk otorisasi
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralModelLabel = 'Teacher'; // (Label Jamak yang benar)

    // Otorisasi: Hanya tampilkan untuk Admin Pusat dan Admin Sekolah
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        // Pastikan User model sudah memiliki method isSuperAdmin()
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
    // [PERBAIKAN QUERY]: Membatasi data untuk Admin Sekolah
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Admin Pusat melihat semua data
        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }
        
        // Admin Sekolah hanya melihat guru di sekolahnya
        if ($user instanceof User && $user->school_id !== null) {
             return parent::getEloquentQuery()
                 ->where('school_id', $user->school_id)
                 ->withoutGlobalScopes([SoftDeletingScope::class]);
        }

        // Default
        return parent::getEloquentQuery()->where('id', null);
    }
    
    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $isSuperAdmin = $user instanceof User && $user->isSuperAdmin();

        return $form
            ->schema([
                // [TAMBAHAN]: Field Pemilihan Sekolah (Hanya Super Admin yang melihat & mengubah)
                Forms\Components\Select::make('school_id')
                    ->relationship(name: 'school', titleAttribute: 'name')
                    ->label('Pilih Sekolah')
                    // Default value diambil dari user
                    ->default(fn () => $user->school_id) 
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(!$isSuperAdmin) 
                    ->visible($isSuperAdmin),

                Forms\Components\FileUpload::make('photo_url')
                    ->label('Foto Guru')
                    ->image() 
                    ->directory('teachers') 
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('position')
                    ->label('Jabatan / Mata Pelajaran')
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('nip')
                    ->label('NIP/NIK')
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
            ]);
    }

    /**
     * [PERBAIKAN MUTATOR]: Hapus pengecekan isSuperAdmin() karena menyebabkan Undefined Method Error.
     * Cukup periksa apakah school_id user ada.
     */
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        
        // Jika school_id user ada, gunakan itu sebagai default
        if ($user instanceof User && $user->school_id !== null) {
            $data['school_id'] = $user->school_id;
        } 
        
        return $data;
    }

    /**
     * [PERBAIKAN MUTATOR]: Hapus pengecekan isSuperAdmin().
     */
    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();
        
        // Jika school_id user ada, pastikan data menyertakannya
        if ($user instanceof User && $user->school_id !== null) {
             // Timpa atau set school_id untuk user admin sekolah
             $data['school_id'] = $user->school_id;
        }
        
        // Jika Super Admin, school_id sudah ada di $data dari field form yang terlihat
        
        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('school.name')
                    ->visible(function () {
                        $user = auth()->user();
                        return $user instanceof User && $user->isSuperAdmin();
                    })
                    ->label('Sekolah Terkait')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}