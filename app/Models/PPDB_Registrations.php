<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; // Wajib untuk Multi-Tenant

class Ppdb_Registrations extends Model
{
    use HasFactory, BelongsToTenant; // Terapkan Trait

    protected $table = 'ppdb_registrations';

    // Kolom yang diizinkan Mass Assignment (sesuai migrasi Anda)
    protected $fillable = [
        'school_id',
        'student_name',
        'origin_school',
        'parent_phone',
        'parent_email',
        'notes',
        'status',
    ];

    // Status otomatis di-cast sebagai string atau enum
    protected $casts = [
        'status' => 'string',
    ];
}