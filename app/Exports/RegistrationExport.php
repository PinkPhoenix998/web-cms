<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RegistrationExport implements FromCollection, WithHeadings, WithDrawings, WithMapping
{
    protected $records;

    public function __construct($records) {
        $this->records = $records;
    }

    public function collection() {
        return $this->records;
    }

    public function headings(): array {
        return [
            'Nama Lengkap', 'NISN', 'NIK', 'Pas Foto', 'KK', 'Akta', 'Jenis Kelamin', 
            'Tempat Lahir', 'Tgl Lahir', 'Alamat', 'Desa', 'Kecamatan', 'WhatsApp', 
            'Ayah', 'Ibu', 'Status'
        ];
    }

    public function map($record): array {
        return [
            $record->full_name,
            $record->nisn,
            $record->nik_kitas,
            '', // Kolom D: Foto
            '', // Kolom E: KK
            '', // Kolom F: Akta
            $record->gender,
            $record->birth_place,
            $record->birth_date,
            $record->address,
            $record->village,
            $record->district,
            $record->phone_number,
            $record->father_name,
            $record->mother_name,
            $record->status,
        ];
    }

    public function drawings() {
        $drawings = [];
        foreach ($this->records as $index => $record) {
            $row = $index + 2;
            $files = ['photo_path' => 'D', 'family_card_path' => 'E', 'birth_cert_path' => 'F'];

            foreach ($files as $field => $col) {
                $path = storage_path('app/public/' . $record->$field);
                if ($record->$field && file_exists($path)) {
                    $drawing = new Drawing();
                    $drawing->setPath($path);
                    $drawing->setHeight(60);
                    $drawing->setCoordinates($col . $row);
                    $drawings[] = $drawing;
                }
            }
        }
        return $drawings;
    }
}