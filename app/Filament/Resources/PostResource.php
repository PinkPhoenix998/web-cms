<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\User; // Penting untuk type casting isSuperAdmin()
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $pluralModelLabel = 'Post'; // (Label Jamak yang benar)

    // --- FILAMENT RESOURCE DEFINITIONS (FORM, TABLE, ETC.) ---

    // 1. Mengontrol siapa yang bisa melihat menu "Posts"
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        
        // Hanya izinkan Admin Pusat dan Admin Sekolah (yang terikat pada sekolah)
        return $user instanceof User && ($user->isSuperAdmin() || $user->school_id !== null);
    }
    
    // 2. Modifikasi getEloquentQuery untuk memfilter data
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        
        // Jika pengguna adalah Super Admin, tampilkan SEMUA data
        if ($user instanceof User && $user->isSuperAdmin()) {
            return parent::getEloquentQuery();
        }

        // Jika pengguna adalah Admin Sekolah, Global Scope di model Post akan secara otomatis memfilter.
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('school.name') // Tampilkan nama sekolah
                    // SOLUSI SINTAKS AMAN: Menggunakan closure dan type casting penuh
                    ->visible(function () {
                        $user = auth()->user();
                        // Type casting untuk menghindari eror "Undefined Method" di editor
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}