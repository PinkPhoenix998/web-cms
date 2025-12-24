<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolProfile extends Model // <<< PERBAIKAN DI SINI: Gunakan CamelCase (SchoolProfile)
{
    use HasFactory;
    
    // Nama tabel
    protected $table = 'school_profiles';

    // Kolom yang diizinkan Mass Assignment (sesuai migrasi Anda)
    protected $fillable = [
        'school_id', 
        'vision',
        'mission',
        'description',
        'address',
        'contact_phone',
        'contact_email',
        'principal_name',
        'principal_photo_url',
        'principal_welcome_message',
    ];
    
    // Relasi one-to-one kembali ke School
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}