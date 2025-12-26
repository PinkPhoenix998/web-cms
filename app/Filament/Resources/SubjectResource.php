<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function getEloquentQuery(): Builder
{
    // Hanya mengambil data yang school_id nya sama dengan sekolah admin yang login
    return parent::getEloquentQuery()
        ->where('school_id', auth()->user()->school_id);
}

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Nama Mata Pelajaran'),
            
            // Tambahkan ini agar school_id terisi otomatis dari user yang login
            Forms\Components\Hidden::make('school_id')
                ->default(auth()->user()->school_id)
                ->required(),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Nama Mata Pelajaran'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->label('Dibuat Pada'),
        ])
        ->filters([
            //
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }    
}
