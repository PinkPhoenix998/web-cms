<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;

    // PINDAHKAN KE SINI (DI DALAM KURUNG KURAWAL KELAS)
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['school_id'] = auth()->user()->school_id;

        return $data;
    }
}