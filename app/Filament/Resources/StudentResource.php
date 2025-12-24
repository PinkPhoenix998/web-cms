<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Direktori & Data Sekolah';
    protected static ?string $modelLabel = 'Peserta Didik';
    protected static ?string $pluralModelLabel = 'Peserta Didik'; // (Label Jamak yang benar)

    // Otorisasi: Hanya tampilkan untuk Admin Pusat dan Admin Sekolah
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
        return parent::getEloquentQuery(); // Global Scope di Model Student akan memfilter
    }

    // Otorisasi Edit/Hapus (wajib)
    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if ($user instanceof User && $user->isSuperAdmin()) return true;
        return $user instanceof User && $record->school_id === $user->school_id;
    }

    public static function canDelete(Model $record): bool
    {
        return static::canEdit($record);
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo_url')
                    ->image()
                    ->disk('public')
                    ->directory('students')
                    ->label('Foto Siswa')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Lengkap Siswa'),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->label('NISN'),
                Forms\Components\TextInput::make('class')
                    ->maxLength(50)
                    ->label('Kelas (Contoh: X TKJ 1)'),
                Forms\Components\Select::make('status')
                    ->options(['aktif' => 'Aktif', 'lulus' => 'Lulus', 'pindah' => 'Pindah'])
                    ->required()
                    ->default('aktif')
                    ->label('Status Siswa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN'),
                Tables\Columns\TextColumn::make('class')
                    ->label('Kelas'),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}