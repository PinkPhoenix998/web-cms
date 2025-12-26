<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use App\Exports\RegistrationExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Pendaftaran PPDB';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. STATUS PENERIMAAN
                Section::make('Status Pendaftaran')
                    ->description('Kelola hasil seleksi siswa di sini')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending (Menunggu)',
                                'accepted' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ])->required()->native(false),
                    ])->columns(1),

                // 2. INFORMASI JALUR
                Section::make('Informasi Pendaftaran')
                    ->schema([
                        TextInput::make('registration_type')->label('Jenis Pendaftaran')->disabled(),
                        TextInput::make('registration_path')->label('Jalur')->disabled(),
                        TextInput::make('origin_school')->label('Sekolah Asal')->disabled(),
                    ])->columns(3),

                // 3. DATA PRIBADI SISWA
                Section::make('Data Pribadi Siswa')
                    ->schema([
                        TextInput::make('full_name')->label('Nama Lengkap')->disabled(),
                        TextInput::make('nisn')->label('NISN')->disabled(),
                        TextInput::make('nik_kitas')->label('NIK/Kitas')->disabled(),
                        TextInput::make('gender')->label('Jenis Kelamin')->disabled(),
                        TextInput::make('birth_place')->label('Tempat Lahir')->disabled(),
                        DatePicker::make('birth_date')->label('Tanggal Lahir')->disabled(),
                        TextInput::make('religion')->label('Agama')->disabled(),
                        TextInput::make('nationality')->label('Kewarganegaraan')->disabled(),
                    ])->columns(3),

                // 4. ALAMAT LENGKAP
                Section::make('Alamat Rumah')
                    ->schema([
                        Textarea::make('address')->label('Alamat Jalan')->disabled()->columnSpanFull(),
                        TextInput::make('village')->label('Desa/Kelurahan')->disabled(),
                        TextInput::make('district')->label('Kecamatan')->disabled(),
                        TextInput::make('city')->label('Kota/Kabupaten')->disabled(),
                        TextInput::make('postal_code')->label('Kode Pos')->disabled(),
                    ])->columns(2),

                // 5. DATA ORANG TUA & KONTAK
                Section::make('Data Orang Tua & Kontak')
                    ->schema([
                        TextInput::make('father_name')->label('Nama Ayah')->disabled(),
                        TextInput::make('father_nik')->label('NIK Ayah')->disabled(),
                        TextInput::make('father_job')->label('Pekerjaan Ayah')->disabled(),
                        TextInput::make('mother_name')->label('Nama Ibu')->disabled(),
                        TextInput::make('mother_nik')->label('NIK Ibu')->disabled(),
                        TextInput::make('mother_job')->label('Pekerjaan Ibu')->disabled(),
                        TextInput::make('phone_number')->label('No. WhatsApp (Aktif)')->disabled(),
                        TextInput::make('email')->label('Email')->disabled(),
                    ])->columns(2),

                // 6. BERKAS DOKUMEN
                Section::make('Berkas Dokumen')
                    ->schema([
                        FileUpload::make('photo_path')->label('Pas Foto')->image()->disabled(),
                        FileUpload::make('family_card_path')->label('Kartu Keluarga')->image()->disabled(),
                        FileUpload::make('birth_cert_path')->label('Akta Lahir')->image()->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('full_name')->label('Nama Lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nisn')->label('NISN')->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tgl Daftar')->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Memunculkan tombol View
                Tables\Actions\EditAction::make(), // Memunculkan tombol Edit
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('export_lengkap')
                        ->label('Export Excel + Gambar')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(fn ($records) => Excel::download(new RegistrationExport($records), 'Data_PPDB_Lengkap.xlsx')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}