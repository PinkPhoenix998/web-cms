<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventsResource\Pages;
use App\Models\Events;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventsResource extends Resource
{
    protected static ?string $model = Events::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Kegiatan Sekolah';
    protected static ?string $modelLabel = 'Event';
    protected static ?string $pluralModelLabel = 'Event'; // (Label Jamak yang benar)

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
    // Otoriśasi edit dan delete sudah benar
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
    
    /**
     * [PERBAIKAN QUERY]: Membatasi data untuk Admin Sekolah
     */
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        // Admin Pusat melihat semua data
        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }

        // Admin Sekolah hanya melihat acara di sekolahnya
        if ($user instanceof User && $user->school_id !== null) {
             return parent::getEloquentQuery()->where('school_id', $user->school_id);
        }
        
        // Default
        return parent::getEloquentQuery()->where('id', null);
    }

    /**
     * [FIX FINAL]: Mutator untuk injeksi school_id saat Create (menghilangkan isSuperAdmin)
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
     * [FIX FINAL]: Mutator untuk injeksi school_id saat Save/Update (menghilangkan isSuperAdmin)
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
                // [TAMBAHAN]: Field Pemilihan Sekolah (Hanya Super Admin yang melihat & mengubah)
                Forms\Components\Select::make('school_id')
                    ->relationship(name: 'school', titleAttribute: 'name')
                    ->label('Pilih Sekolah Terkait')
                    ->default(fn () => $user->school_id)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(!$isSuperAdmin) 
                    ->visible($isSuperAdmin),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Acara'),
                Forms\Components\DateTimePicker::make('date_time')
                    ->required()
                    ->label('Tanggal dan Waktu Acara'),
                Forms\Components\Select::make('status')
                    ->options(['upcoming' => 'Akan Datang', 'finished' => 'Selesai'])
                    ->required()
                    ->default('upcoming')
                    ->label('Status Event'),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Acara')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('banner_url')
                    ->image()
                    ->disk('public')
                    ->directory('event-banners')
                    ->label('Banner Acara')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Judul Acara'),
                Tables\Columns\TextColumn::make('date_time')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu'),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvents::route('/create'),
            'edit' => Pages\EditEvents::route('/{record}/edit'),
        ];
    }
}