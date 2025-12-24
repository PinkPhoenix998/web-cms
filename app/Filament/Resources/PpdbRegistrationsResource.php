<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbRegistrationsResource\Pages;
use App\Models\PpdbRegistrations;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistrationsResource extends Resource
{
    protected static ?string $model = PpdbRegistrationsResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Administrasi';
    protected static ?string $modelLabel = 'Pendaftar PPDB';
    protected static ?string $pluralModelLabel = 'Pendaftar PPDB'; // (Label Jamak yang benar)

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
        return parent::getEloquentQuery(); // Global Scope akan memfilter
    }

    // PPDB biasanya tidak perlu form Create, hanya perlu View/Edit Status
    public static function canCreate(): bool
    {
        return false; // Pendaftaran dilakukan via form publik
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('student_name')
                    ->label('Nama Calon Siswa')
                    ->disabled(),
                Forms\Components\TextInput::make('origin_school')
                    ->label('Asal Sekolah')
                    ->disabled(),
                Forms\Components\TextInput::make('parent_phone')
                    ->label('Kontak Orang Tua')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'Baru Masuk',
                        'processed' => 'Sedang Diproses',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->label('Status Pendaftaran'),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan Admin')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('parent_phone')
                    ->label('Kontak'),
                Tables\Columns\TextColumn::make('origin_school')
                    ->label('Asal Sekolah'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tgl Daftar'),
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
            'index' => Pages\ListPpdbRegistrations::route('/'),
            'edit' => Pages\EditPpdbRegistrations::route('/{record}/edit'),
        ];
    }
}