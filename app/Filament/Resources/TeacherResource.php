<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use App\Models\User;
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
    protected static ?string $navigationGroup = 'Direktori & Data Sekolah';

    protected static ?string $pluralModelLabel = 'Teacher';

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }
        
        if ($user instanceof User && $user->school_id !== null) {
             return parent::getEloquentQuery()
                 ->where('school_id', $user->school_id)
                 ->withoutGlobalScopes([SoftDeletingScope::class]);
        }

        return parent::getEloquentQuery()->where('id', null);
    }
    
    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $isSuperAdmin = $user instanceof User && $user->isSuperAdmin();

        return $form
            ->schema([
                Forms\Components\Select::make('school_id')
                    ->relationship(name: 'school', titleAttribute: 'name')
                    ->label('Pilih Sekolah')
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

                // --- TAMBAHAN BAGIAN JENIS KELAMIN ---
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),

                // --- TAMBAHAN BAGIAN DROPDOWN MATA PELAJARAN ---
                Forms\Components\Select::make('subject_id')
                    ->relationship(
                        name: 'subject', 
                        titleAttribute: 'name',
                        // Filter agar hanya muncul mata pelajaran milik sekolah user tersebut
                        modifyQueryUsing: fn (Builder $query) => $query->where('school_id', auth()->user()->school_id)
                    )
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                // Forms\Components\TextInput::make('position')
                //     ->label('Jabatan Tambahan')
                //     ->placeholder('Contoh: Wali Kelas / Wakasek')
                //     ->maxLength(255),
                    
                Forms\Components\TextInput::make('nip')
                    ->label('NIP/NIK')
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
            ]);
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        if ($user instanceof User && $user->school_id !== null) {
            $data['school_id'] = $user->school_id;
        } 
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();
        if ($user instanceof User && $user->school_id !== null) {
             $data['school_id'] = $user->school_id;
        }
        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                // Menampilkan label Gender di tabel
                Tables\Columns\TextColumn::make('gender')
                    ->label('L/P'),
                // Menampilkan nama Mata Pelajaran dari relasi di tabel
                Tables\Columns\TextColumn::make('subject.name')
                    ->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('school.name')
                    ->visible(function () {
                        $user = auth()->user();
                        return $user instanceof User && $user->isSuperAdmin();
                    })
                    ->label('Sekolah Terkait')
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