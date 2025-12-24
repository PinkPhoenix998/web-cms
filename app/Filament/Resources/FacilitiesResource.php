<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilitiesResource\Pages;
use App\Models\Facilities;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class FacilitiesResource extends Resource
{
    protected static ?string $model = Facilities::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Direktori & Data Sekolah';
    protected static ?string $modelLabel = 'Daftar Fasilitas';

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
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Fasilitas (Contoh: Lab Komputer)'),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Fasilitas')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo_url')
                    ->image()
                    ->disk('public')
                    ->directory('facilities')
                    ->label('Foto Fasilitas')
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
                    ->label('Nama Fasilitas'),
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
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacilities::route('/create'),
            'edit' => Pages\EditFacilities::route('/{record}/edit'),
        ];
    }
}