<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Hanya biarkan tombol Create standar di sini
            Actions\CreateAction::make()
                ->label('Tambah Pendaftaran Manual'),
        ];
    }
}