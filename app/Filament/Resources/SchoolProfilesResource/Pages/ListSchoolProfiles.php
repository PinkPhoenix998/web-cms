<?php

namespace App\Filament\Resources\SchoolProfilesResource\Pages;

use App\Filament\Resources\SchoolProfilesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSchoolProfiles extends ListRecords
{
    protected static string $resource = SchoolProfilesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
