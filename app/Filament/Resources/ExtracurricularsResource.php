<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtracurricularsResource\Pages;
use App\Models\extracurriculars;
use App\Models\User; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model; 

class ExtracurricularsResource extends Resource 
{
    protected static ?string $model = extracurriculars::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Kegiatan Sekolah';
    protected static ?string $modelLabel = 'Daftar Ekstrakurikuler';
    protected static ?string $pluralModelLabel = 'Daftar Ekstrakurikuler'; // (Label Jamak yang benar
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
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
     * [FIX FINAL]: Mutator tanpa pengecekan isSuperAdmin().
     */
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();
        
        if ($user instanceof User && $user->school_id !== null) {
            $data['school_id'] = $user->school_id;
        } 
        
        return $data;
    }

    /**
     * [FIX FINAL]: Mutator tanpa pengecekan isSuperAdmin().
     */
    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();
        
        if ($user instanceof User && $user->school_id !== null) {
            $data['school_id'] = $user->school_id;
        }
        
        return $data;
    }

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $isSuperAdmin = $user instanceof User && $user->isSuperAdmin();

        return $form
            ->schema([
                // Field Pemilihan Sekolah (Hanya Super Admin yang melihat & mengubah)
                Forms\Components\Select::make('school_id')
                    ->relationship(name: 'school', titleAttribute: 'name')
                    ->label('Pilih Sekolah Terkait')
                    ->default(fn () => $user->school_id)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(!$isSuperAdmin) 
                    ->visible($isSuperAdmin),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Eskul (Contoh: Futsal)'),
                Forms\Components\TextInput::make('instructor_name')
                    ->maxLength(255)
                    ->label('Nama Pembimbing'),
                Forms\Components\TextInput::make('schedule')
                    ->maxLength(255)
                    ->label('Jadwal (Contoh: Setiap Jumat 14:00)'),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Eskul')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo_url')
                    ->image()
                    ->disk('public')
                    ->directory('eskul')
                    ->label('Foto / Banner Eskul')
                    ->columnSpanFull(),
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
                    ->label('Nama Eskul'),
                Tables\Columns\TextColumn::make('instructor_name')
                    ->label('Pembimbing'),
                Tables\Columns\TextColumn::make('schedule')
                    ->label('Jadwal'),
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
            'index' => Pages\ListExtracurriculars::route('/'),
            'create' => Pages\CreateExtracurriculars::route('/create'),
            'edit' => Pages\EditExtracurriculars::route('/{record}/edit'),
        ];
    }
}