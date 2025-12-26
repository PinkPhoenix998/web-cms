<?php

namespace App\Filament\Resources\ExtracurricularsResource\Pages;

use App\Filament\Resources\ExtracurricularsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtracurriculars extends ListRecords
{
    protected static string $resource = ExtracurricularsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
