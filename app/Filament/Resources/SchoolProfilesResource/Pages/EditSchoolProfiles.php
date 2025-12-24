<?php

namespace App\Filament\Resources\SchoolProfilesResource\Pages;

use App\Filament\Resources\SchoolProfilesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSchoolProfiles extends EditRecord
{
    protected static string $resource = SchoolProfilesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
