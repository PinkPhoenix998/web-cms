<?php

namespace App\Filament\Resources\PpdbRegistrationsResource\Pages;

use App\Filament\Resources\PpdbRegistrationsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPpdbRegistrations extends ListRecords
{
    protected static string $resource = PpdbRegistrationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
