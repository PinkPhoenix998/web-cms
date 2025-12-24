<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use App\Models\User; // Penting untuk otorisasi
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $pluralModelLabel = 'Gallery'; // (Label Jamak yang benar)

    // Otorisasi: Hanya tampilkan untuk Admin Pusat dan Admin Sekolah
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
    // Query: Gunakan Global Scope dari Model Gallery
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Tipe Media')
                    ->options([
                        'image' => 'Gambar/Foto',
                        'video' => 'Video (URL Tertanam)',
                    ])
                    ->required()
                    ->default('image')
                    ->reactive() // Agar bisa bereaksi terhadap field di bawah
                    ->columnSpanFull(),

                // Field Upload File (Hanya Muncul Jika Tipe Media = Gambar)
                Forms\Components\FileUpload::make('file_path')
                    ->label('Unggah Gambar')
                    ->image()
                    ->directory('gallery') // Simpan di storage/app/public/gallery
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'image')
                    ->hidden(fn (Forms\Get $get): bool => $get('type') === 'video'),

                // Field URL Video (Hanya Muncul Jika Tipe Media = Video)
                Forms\Components\TextInput::make('file_path')
                    ->label('URL Embed Video (Youtube/Vimeo)')
                    ->required(fn (Forms\Get $get): bool => $get('type') === 'video')
                    ->hidden(fn (Forms\Get $get): bool => $get('type') === 'image')
                    ->url(), // Validasi harus berupa URL

                Forms\Components\TextInput::make('title')
                    ->label('Judul Album/Foto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('caption')
                    ->label('Keterangan Singkat')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Media')
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default untuk video

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'image' => 'success',
                        'video' => 'info',
                    }),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}