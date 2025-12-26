<?php

namespace App\Filament\Resources\SchoolProfilesResource\Pages;

use App\Filament\Resources\SchoolProfilesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSchoolProfiles extends CreateRecord
{
    protected static string $resource = SchoolProfilesResource::class;

    /**
     * INJEKSI school_id LANGSUNG DARI HALAMAN CREATE
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        // Pengecekan ekstra: Pastikan user terautentikasi dan memiliki school_id
        if (auth()->check() && $user && $user->school_id !== null) {
            $data['school_id'] = $user->school_id;
        }

        return $data;
    }
}